<?php

namespace App\Http\Controllers;

use App\Models\IdCardTemplate;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class IdCardTemplateController extends Controller
{
    public function index()
    {
        $templates = IdCardTemplate::latest()->get();

        return view('pages.templates.index', compact('templates'));
    }

    public function create()
    {
        return view('pages.templates.form', [
            'template' => new IdCardTemplate([
                'name' => '',
                'is_active' => true,
                'is_default' => false,
                'settings' => IdCardTemplate::defaults(),
            ]),
            'settings' => IdCardTemplate::defaults(),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $this->validated($request);
            $template = IdCardTemplate::create($data);

            if (! empty($data['is_default'])) {
                $template->makeDefault();
            }

            return redirect()
                ->route('templates.edit', $template->id)
                ->with('success', 'Template created successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->withErrors($e->errors());
        }
    }

    public function edit($id)
    {
        $template = IdCardTemplate::findOrFail($id);

        return view('pages.templates.form', [
            'template' => $template,
            'settings' => $template->mergedSettings(),
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, $id)
    {
        $template = IdCardTemplate::findOrFail($id);

        try {
            $data = $this->validated($request, $template);
            $template->update($data);

            if (! empty($data['is_default'])) {
                $template->makeDefault();
            }

            return redirect()
                ->route('templates.edit', $template->id)
                ->with('success', 'Template updated successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->withErrors($e->errors());
        }
    }

    public function destroy($id)
    {
        $template = IdCardTemplate::findOrFail($id);

        if ($template->is_default) {
            return redirect()
                ->route('templates.index')
                ->with('error', 'Cannot delete the default template. Set another as default first.');
        }

        $this->deleteLogoFile($template->mergedSettings()['logo'] ?? null);
        $template->delete();

        return redirect()
            ->route('templates.index')
            ->with('success', 'Template deleted successfully.');
    }

    public function setDefault($id)
    {
        $template = IdCardTemplate::findOrFail($id);
        $template->makeDefault();

        return redirect()
            ->route('templates.index')
            ->with('success', 'Default template updated.');
    }

    public function preview($id)
    {
        $template = IdCardTemplate::findOrFail($id);
        $student = Student::where('is_registered', 1)->latest()->first()
            ?: Student::latest()->first();

        if (! $student) {
            $student = new Student([
                'sid' => 'SID-DEMO',
                'student_name' => 'Alex Morgan',
                'first_name' => 'Alex',
                'last_name' => 'Morgan',
                'class' => 'Grade 5',
                'campus' => 'Main Campus',
                'father_name' => 'Jordan Morgan',
                'phone' => '03001234567',
                'address' => '12 Demo Street',
                'image' => null,
            ]);
        }

        return view('cards.print', [
            'students' => collect([$student]),
            'type' => 'student',
            'template' => $template,
            'preview' => true,
        ]);
    }

    protected function validated(Request $request, ?IdCardTemplate $existing = null): array
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'is_active' => 'nullable|boolean',
            'is_default' => 'nullable|boolean',
            'organization' => 'required|string|max:120',
            'tagline' => 'nullable|string|max:160',
            'layout' => 'required|in:classic,stacked,banner',
            'logo' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'remove_logo' => 'nullable|boolean',
            'show_logo' => 'nullable|boolean',
            'logo_size' => 'required|in:small,medium,large',
            'header_bg' => 'required|string|max:20',
            'header_text' => 'required|string|max:20',
            'body_bg' => 'required|string|max:20',
            'footer_bg' => 'required|string|max:20',
            'footer_text' => 'required|string|max:20',
            'name_color' => 'required|string|max:20',
            'label_color' => 'required|string|max:20',
            'value_color' => 'required|string|max:20',
            'accent_color' => 'required|string|max:20',
            'border_color' => 'required|string|max:20',
            'photo_size' => 'required|in:small,medium,large',
            'student_badge' => 'nullable|string|max:40',
            'parent_badge' => 'nullable|string|max:40',
            'show_badge' => 'nullable|boolean',
            'show_photo' => 'nullable|boolean',
            'show_sid' => 'nullable|boolean',
            'show_class' => 'nullable|boolean',
            'show_campus' => 'nullable|boolean',
            'show_guardian' => 'nullable|boolean',
            'show_phone' => 'nullable|boolean',
            'show_address' => 'nullable|boolean',
            'show_footer_sid' => 'nullable|boolean',
        ]);

        $boolKeys = [
            'show_logo', 'show_badge', 'show_photo', 'show_sid', 'show_class', 'show_campus',
            'show_guardian', 'show_phone', 'show_address', 'show_footer_sid',
        ];

        $settings = IdCardTemplate::defaults();
        foreach ($settings as $key => $default) {
            if ($key === 'logo') {
                continue;
            }
            if (array_key_exists($key, $validated)) {
                $settings[$key] = in_array($key, $boolKeys, true)
                    ? $request->boolean($key)
                    : $validated[$key];
            } elseif (in_array($key, $boolKeys, true)) {
                $settings[$key] = false;
            }
        }

        $currentLogo = $existing ? ($existing->mergedSettings()['logo'] ?? null) : null;

        if ($request->boolean('remove_logo')) {
            $this->deleteLogoFile($currentLogo);
            $settings['logo'] = null;
        } elseif ($request->hasFile('logo')) {
            $this->deleteLogoFile($currentLogo);
            $path = $request->file('logo')->store('templates/logos', 'public');
            $assetUrl = rtrim(env('ASSET_URL', url('/')), '/');
            $settings['logo'] = $assetUrl.'/storage/'.$path;
        } else {
            $settings['logo'] = $currentLogo;
        }

        return [
            'name' => $validated['name'],
            'is_active' => $request->boolean('is_active'),
            'is_default' => $request->boolean('is_default'),
            'settings' => $settings,
        ];
    }

    protected function deleteLogoFile(?string $logoUrl): void
    {
        if (! $logoUrl) {
            return;
        }

        $path = parse_url($logoUrl, PHP_URL_PATH) ?? '';
        $relative = ltrim(str_replace('/storage/', '', $path), '/');

        if ($relative && str_starts_with($relative, 'templates/logos/')) {
            Storage::disk('public')->delete($relative);
        }
    }
}
