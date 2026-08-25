# Design System Specification: The Architectural Craftsman

## 1. Overview & Creative North Star
**Creative North Star: "The Geometric Atelier"**
This design system moves beyond the standard "handyman" aesthetic to position the craftsman as an architect of surfaces. It is rooted in the precision of the grid, the tactile nature of stone, and the intentionality of a master mosaicist. 

To break the "template" look, we employ **Intentional Asymmetry**. Layouts should mimic the composition of a bespoke floor pattern—using wide-open negative space contrasted against dense, highly detailed clusters of information. We reject the "boxed-in" web; instead, we treat the screen as a continuous slab where elements are etched, inlaid, or layered with mathematical precision.

## 2. Colors & Surface Philosophy
The palette is a dialogue between deep red mineral tones and the metallic warmth of copper-gold. It evokes a workshop that is both clean and steeped in tradition.

### Color Tokens
Tokens map 1:1 to `src/styles/global.css` — that file is the source of truth; this doc only names the roles.

*   **Primary (Red):** `--color-default` (#822c2a) | hover: `--color-light` (#a13a35)
*   **Accent (Copper-Gold):** `--color-accent` (#8b6e55) | hover: `--color-accent-hover` (#c7a481)
*   **Neutral (Stone):** `--color-erlich-white` (#f2f2f2) base surface | `--color-light-gray` (#e6e6e6) inset surface | `--color-black` (#000000) text

### The "No-Line" Rule
Standard 1px solid borders are strictly prohibited for sectioning. We define space through **Tonal Shifts**. To separate the Hero from the Gallery, shift the background from `--color-erlich-white` to `--color-light-gray`. The only "lines" allowed are functional "Grout Lines"—using the `--color-accent` copper accent—applied sparingly as intentional dividers.

### Surface Hierarchy & Nesting
Treat the UI as a series of physical layers. 
1.  **Base:** `--color-erlich-white` (#f2f2f2) – The main floor.
2.  **Inset:** `--color-light-gray` (#e6e6e6) – Use for content sections that feel "carved into" the page.
3.  **Elevated:** `#ffffff` – Use for floating "Glassmorphism" panels (e.g., the sticky nav) with a `backdrop-filter: blur(12px)`.

### Signature Texture
All base backgrounds should feature a subtle, repeating SVG grid (`--color-light-gray` #e6e6e6 at 5% opacity). This reinforces the "Tile" motif without distracting from the content.

## 3. Typography: The Editorial Contrast
We use a high-contrast typographic pairing to signal both modern precision and heritage.

*   **Headings (The Heritage):** `notoSerif` (Display & Headline scales). These should be tracked slightly tighter (-2%) to feel dense and authoritative. Use `headline-lg` (2rem) for section titles to create an editorial, magazine-like feel.
*   **Body (The Precision):** `inter` (Title & Body scales). This clean, Swiss-influenced sans-serif provides the "blueprint" feel. Use `body-md` (0.875rem) for general descriptions to maintain a refined, minimalist scale.
*   **The Signature Label:** Use `label-md` (Inter, All-Caps, tracked out +10%) in `--color-accent` (Copper) for small eyebrows above headings.

## 4. Elevation & Depth: Tonal Layering
We reject heavy drop shadows in favor of **Ambient Light** and **Materiality**.

*   **The Layering Principle:** Rather than shadows, achieve depth by placing a `#ffffff` card on a `--color-light-gray` background. This creates a "lift" that feels like a physical tile placed on a substrate.
*   **Ambient Shadows:** For interactive hover states, use an extra-diffused shadow: `box-shadow: 0 20px 40px rgba(130, 44, 42, 0.04)`. Note the use of a tinted `--color-default` red for the shadow to mimic natural light refraction.
*   **The "Ghost Border":** For input fields or cards where containment is vital, use a 1px border of `--color-light-gray` at **15% opacity**. It should be felt, not seen.
*   **Sharpness:** All corners must be **0px (Sharp)**. This system celebrates the 90-degree precision of a cut stone.

## 5. Components

### Buttons: The Inlaid Tile
*   **Default padding (all buttons, all variants):** `0.8rem` top/bottom, `0.9rem` left/right — Tailwind: `py-[0.8rem] px-[0.9rem]`.
*   **Primary:** `--color-default` (#822c2a) background, white text. Sharp corners. On hover, shift to `--color-light` (#a13a35) with a subtle 2px copper (`--color-accent`) bottom-border.
*   **Secondary:** Ghost style. Transparent background, `--color-default` text, 1px `--color-default` border at 20% opacity.
*   **Tertiary:** Text-only, `--color-accent` (Copper) color, All-caps `label-md` styling.

### Form Fields: The Custom Tickmark
*   **Cap.js CAPTCHA widget** (`src/components/CapWidget.astro`): the widget's own default theme (rounded corners, `system-ui` font) is overridden via its documented CSS custom properties (`--cap-border-radius`, `--cap-checkbox-border-radius`: `0px`; `--cap-font`: `var(--font-sans)`; `--cap-color`/`--cap-spinner-color`/`--cap-spinner-background-color` mapped to `--color-black`/`--color-accent`/`--color-light-gray`) so it reads as part of this system, not a third-party embed. See the `<style>` block in that component for the full mapping.
*   **Checkbox (e.g. DSGVO consent):** not a native checkbox appearance — `appearance-none`, explicit `h-5 w-5` square, 1px `--color-black` border at 20% opacity. Checked state: fills `--color-default` (red) background + border, with a white checkmark from the `iconamoon:check-bold` icon (Iconify's `@iconify-json/iconamoon` collection, `bun add`ed as a dependency; `astro-icon` resolves `iconamoon:*` names automatically once the package is installed) overlaid via a sibling element toggled with `peer-checked:block`. Focus state: `focus-visible:outline` ring (matches `src/components/Link.astro`'s convention), since a bottom-border focus effect doesn't apply to a square control.

### Cards: The Mosaic Units
*   No borders. Use background `--color-light-gray`.
*   **Interaction:** On hover, the card shifts to `#ffffff` and lifts 4px via a tinted ambient shadow. 
*   **Content:** Forbid divider lines within cards. Use `spacing-6` (1.5rem) to separate the image from the text.

### Navigation: The Floating Header
*   **Sticky State:** Apply `#ffffff` with 80% opacity and a `backdrop-filter: blur(20px)`.
*   **Detail:** A 1px `--color-accent` (Copper) border on the *bottom only* to represent a grout line.

### Inputs: The Blueprint
*   Background: `#ffffff`.
*   Border: Bottom-only, 1px `--color-light-gray`.
*   Focus State: Bottom-border expands to 2px and shifts to `--color-accent` (Copper).

## 6. Do's and Don'ts

### Do
*   **Do** use extreme vertical whitespace (e.g., `spacing-24`) to separate major narrative sections.
*   **Do** align text to a strict 12-column grid, but feel free to leave 4-6 columns empty for an "asymmetric" editorial look.
*   **Do** use high-quality, tactile photography of stone textures and finished work.

### Don't
*   **Don't** use rounded corners (`0px` is the law of the system).
*   **Don't** use standard "Blue" for links. All interactive triggers must be `--color-default` or `--color-accent`.
*   **Don't** use divider lines to separate list items; use subtle background alternates (Zebra striping without lines).
