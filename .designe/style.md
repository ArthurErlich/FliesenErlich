# Design System Specification: The Architectural Craftsman

## 1. Overview & Creative North Star
**Creative North Star: "The Geometric Atelier"**
This design system moves beyond the standard "handyman" aesthetic to position the craftsman as an architect of surfaces. It is rooted in the precision of the grid, the tactile nature of stone, and the intentionality of a master mosaicist. 

To break the "template" look, we employ **Intentional Asymmetry**. Layouts should mimic the composition of a bespoke floor pattern—using wide-open negative space contrasted against dense, highly detailed clusters of information. We reject the "boxed-in" web; instead, we treat the screen as a continuous slab where elements are etched, inlaid, or layered with mathematical precision.

## 2. Colors & Surface Philosophy
The palette is a dialogue between deep, oxblood mineral tones and the metallic warmth of copper. It evokes a workshop that is both clean and steeped in tradition.

### Color Tokens
*   **Primary (Oxblood):** `primary` (#631516) | `primary_container` (#822c2a)
*   **Secondary (Copper):** `secondary` (#745941) | `secondary_fixed` (#ffdcc0)
*   **Neutral (Stone):** `surface` (#fff8f7) | `surface_container_low` (#fdf1f1) | `on_surface` (#201a1a)

### The "No-Line" Rule
Standard 1px solid borders are strictly prohibited for sectioning. We define space through **Tonal Shifts**. To separate the Hero from the Gallery, shift the background from `surface` to `surface_container_low`. The only "lines" allowed are functional "Grout Lines"—using the `secondary` copper accent—applied sparingly as intentional dividers.

### Surface Hierarchy & Nesting
Treat the UI as a series of physical layers. 
1.  **Base:** `surface` (#fff8f7) – The main floor.
2.  **Inset:** `surface_container_low` – Use for content sections that feel "carved into" the page.
3.  **Elevated:** `surface_container_highest` – Use for floating "Glassmorphism" panels (e.g., the sticky nav) with a `backdrop-filter: blur(12px)`.

### Signature Texture
All `surface` backgrounds should feature a subtle, repeating SVG grid (`outline_variant` #dcc0be at 5% opacity). This reinforces the "Tile" motif without distracting from the content.

## 3. Typography: The Editorial Contrast
We use a high-contrast typographic pairing to signal both modern precision and heritage.

*   **Headings (The Heritage):** `notoSerif` (Display & Headline scales). These should be tracked slightly tighter (-2%) to feel dense and authoritative. Use `headline-lg` (2rem) for section titles to create an editorial, magazine-like feel.
*   **Body (The Precision):** `inter` (Title & Body scales). This clean, Swiss-influenced sans-serif provides the "blueprint" feel. Use `body-md` (0.875rem) for general descriptions to maintain a refined, minimalist scale.
*   **The Signature Label:** Use `label-md` (Inter, All-Caps, tracked out +10%) in `secondary` (Copper) for small eyebrows above headings.

## 4. Elevation & Depth: Tonal Layering
We reject heavy drop shadows in favor of **Ambient Light** and **Materiality**.

*   **The Layering Principle:** Rather than shadows, achieve depth by placing a `surface_container_lowest` (#ffffff) card on a `surface_dim` background. This creates a "lift" that feels like a physical tile placed on a substrate.
*   **Ambient Shadows:** For interactive hover states, use an extra-diffused shadow: `box-shadow: 0 20px 40px rgba(99, 21, 22, 0.04)`. Note the use of a tinted `primary` color for the shadow to mimic natural light refraction.
*   **The "Ghost Border":** For input fields or cards where containment is vital, use a 1px border of `outline_variant` at **15% opacity**. It should be felt, not seen.
*   **Sharpness:** All corners must be **0px (Sharp)**. This system celebrates the 90-degree precision of a cut stone.

## 5. Components

### Buttons: The Inlaid Tile
*   **Primary:** `primary_container` (#822c2a) background, `on_primary` text. Sharp corners. On hover, shift to `primary` (#631516) with a subtle 2px copper bottom-border.
*   **Secondary:** Ghost style. Transparent background, `primary` text, 1px `outline` border at 20% opacity.
*   **Tertiary:** Text-only, `secondary` (Copper) color, All-caps `label-md` styling.

### Cards: The Mosaic Units
*   No borders. Use background `surface_container_low`.
*   **Interaction:** On hover, the card shifts to `surface_container_lowest` and lifts 4px via a tinted ambient shadow. 
*   **Content:** Forbid divider lines within cards. Use `spacing-6` (1.5rem) to separate the image from the text.

### Navigation: The Floating Header
*   **Sticky State:** Apply `surface_container_highest` with 80% opacity and a `backdrop-filter: blur(20px)`.
*   **Detail:** A 1px `secondary` (Copper) border on the *bottom only* to represent a grout line.

### Inputs: The Blueprint
*   Background: `surface_container_lowest`.
*   Border: Bottom-only, 1px `outline_variant`.
*   Focus State: Bottom-border expands to 2px and shifts to `secondary` (Copper).

## 6. Do's and Don'ts

### Do
*   **Do** use extreme vertical whitespace (e.g., `spacing-24`) to separate major narrative sections.
*   **Do** align text to a strict 12-column grid, but feel free to leave 4-6 columns empty for an "asymmetric" editorial look.
*   **Do** use high-quality, tactile photography of stone textures and finished work.

### Don't
*   **Don't** use rounded corners (`0px` is the law of the system).
*   **Don't** use 100% black for text; use `on_surface` (#201a1a) for a softer, premium feel.
*   **Don't** use standard "Blue" for links. All interactive triggers must be `primary` or `secondary`.
*   **Don't** use divider lines to separate list items; use subtle `surface` color alternates (Zebra striping without lines).