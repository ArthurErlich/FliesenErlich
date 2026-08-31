# Content migration capture — erlich-fliesen.de

Ticket: [#14 — Capture erlich-fliesen.de copy per page/section](https://git.arthurerlich.de/haylan/FliesenErlich/issues/14)

Captured 2026-08-12 via WebFetch's markdown conversion of the live site. This is a **single-page site**: "Über mich", "Portfolio", "Referenzen" and "Kontakt" are not separate pages/URLs — they are in-page anchor sections (`#ueber`, `/#Portfolio`, `/#Referenzen`, `/#Kontakt`) on the homepage. There is no separate URL to fetch for each of them; all copy below comes from the one fetch of `https://www.erlich-fliesen.de/`. Impressum (`/69/impressum`) and Datenschutz (`/70/datenschutz`) were intentionally **not** captured here — that's ticket #11.

Transcription only. No rewriting, no fixes to grammar/typos in the source copy.

---

## Startseite / Home (full page)

Source: https://www.erlich-fliesen.de/

Page title (browser tab): "Erlich Fliesen - Verlegung von Fliesen und Mosaik"

### Heading / block breakdown, top to bottom

1. Header / top bar — logo, phone, email
2. Navigation menu — Über mich / Portfolio / Referenzen / Kontakt / Impressum / Datenschutz
3. Hero slider (2 images)
4. Section `#ueber` — "Über mich" (heading + 2 paragraphs)
5. Section `Portfolio` — "Portfolio" (heading + 3 subsections: Für Privatleute / Für Individualisten / Für Architekten)
6. Section `Referenzen` — "Referenzen" (heading + intro paragraph, 3-item list, 2 closing paragraphs)
7. Section `Kontakt` — "Kontakt" (heading + 2 paragraphs + contact form)
8. Mobile menu — "Direkt anrufen" call link
9. Footer — Login / Impressum / Datenschutz links, "Webdesign by Homepage Atelier e.K" credit

### Header / top bar

- Logo image: `/images/2761/logo-erlich.png`, alt text "Logo Fliesenleger Erlich"
- Phone: `0163 431064 6` (tel link)
- Email: `fliesenerlich@hotmail.com` (mailto link, prefilled subject/body "Schreiben Sie uns!")
- Opening hours shown near contact info: "8:00 - 18:00"

### Navigation menu (verbatim labels)

- Über mich → `#ueber`
- Portfolio → `/#Portfolio`
- Referenzen → `/#Referenzen`
- Kontakt → `/#Kontakt`
- Impressum → `/69/impressum`
- Datenschutz → `/70/datenschutz`

### Hero / slider

Two slider images referenced via the CMS's dynamic image endpoint (no descriptive alt text captured by the fetch):

- `/image.php?id=2781`
- `/image.php?id=2798`

(No captions or overlay copy were present in the fetched markdown — the slider appears to be image-only.)

### Section: Über mich

**Heading:** Über mich

**Body copy (verbatim):**

> Mein Handwerksunternehmen, Fliesen Erlich, ist seit vielen Jahren die erste Adresse, wenn es um die Gestaltung von Wänden und Böden geht. Hierbei sehe ich mich nicht nur als Fliesenleger, sondern als aktiver Gestalter für Lebensräume. Wurden Fliesen lange Zeit hauptsächlich nur in Badezimmern verlegt, beziehungsweise für die Badezimmersanierung verwendet, so hat sich dies im Laufe der Zeit gewandelt. Mittlerweile finden wir Fliesen in allen Wohnbereichen wieder, auch in jeder Form und Farbe, etwa als Mosaik oder Platten.
>
> Hierbei übernehme ich nicht nur die Verlegung der Fliesen, sondern sorge für gerade Wände und Böden, sowie das fachgerechte Vorbereiten der Untergründe. Gerne unterstütze ich meine Kunden bei der Suche nach den richtigen Wunschfliesen.

**Media in this section:**

- Image `/images/2792/beratung-1.png`, alt text "Waldemar Erlich" — a portrait/consultation photo of the proprietor, positioned alongside the About text.

### Section: Portfolio

**Heading:** Portfolio

Three subsections (segments), each with its own subheading and body copy — captured in full below.

#### Für Privatleute

> Der Mensch strebt nach Veränderung, und überlegt in gewissen Zeiträumen, was er in seinem Wohnumfeld verändern kann. Oft sind es Kleinigkeiten, wie etwa die Wand in der Küche, oder eben komplexe Räume wie ein Badezimmer. Mit meiner fachmännischen Erfahrung zeige ich Ihnen, wie Sie mit Fliesen in kürzester Zeit eine neue Raumgestaltung vornehmen können. Für die Fliesenauswahl stehen heutzutage alle erdenklichen Farben und Oberflächen zur Verfügung. Gerne zeige ich Ihnen vorab eine Auswahl möglicher Kombinationen, angepasst auf Ihre persönlichen Wünsche.

#### Für Individualisten

> So verschieden der Mensch, so unterschiedlich ist der Wunsch nach Wohndesign. Industriehallen und komplexe Fabrikgebäude wandeln sich zum Wohnraum, leerstehende und verfallende Häuser erhalten eine neue Wohnraumfunktion. Hierbei leisten Fliesen ganze Arbeit. Sie unterstützen mit ihrer Form und Farbe den Wohnzweck und sorgen für das gewünschte Ambiente.
>
> Ob Fliesen in Mosaik, in Platten, oder mit angepasster Oberfläche. Denn wer individuell wohnen möchte, hat ein Recht auf individuelles Design. Gerne unterstütze ich Sie bei einem solchen Vorhaben und zeige Ihnen die Welt der Fliesen. Vorzunehmende Untergrundvorbereitungen werden selbstverständlich vorher besprochen.

**Media:** Image `/images/2982/leistungen.png` (no alt text captured), positioned between the "Für Individualisten" and "Für Architekten" copy — appears to be a services/work illustration or photo.

#### Für Architekten

> Als Architekt sind Sie auf zuverlässige Handwerksunternehmen angewiesen. Hier möchte ich meinen Handwerksbetrieb für die Verlegung von Fliesen empfehlen, und versichere schon jetzt die fachgerechte Verlegung von Fliesen. Bei Besprechungen mit dem Bauherrn bin ich auf Wunsch gerne anwesend und kann auch eine geeignete Auswahl an Fliesen vorlegen. Neben der reinen Verfliesung übernehme ich auch:
>
> - Estrich Lieferung und Einbau
> - Untergrundvorbereitungen
>
> Bitte berücksichtigen Sie meinen Handwerksbetrieb bei Ihren Ausschreibungen.

### Section: Referenzen

**Heading:** Referenzen

**Body copy (verbatim):**

> Was macht eigentlich ein Fliesenleger? Sie ahnen es bestimmt schon. Wir verlegen Fliesen. Aber wir sind mehr. Nämlich:
>
> - Berater für Raumdesign und Sanierung (zum Beispiel Badezimmersanierung)
> - Raumplaner
> - Farbgestalter
>
> So ist etwa die eigentliche Fliesenverlegung nicht der wesentlichste Teil eines Auftrages. Ausschlaggebend sind die: Vorplanung, die Begutachtung der Flächen und ganz wichtig ist die Untergrundvorbereitung. Schauen Sie sich bitte meine Referenzbilder an. Sie spiegeln meine Begeisterung für dieses Handwerk wieder.
>
> Ich freue mich schon jetzt darauf, Ihr Bauvorhaben begleiten zu dürfen.

**Media:** The copy explicitly refers to "Referenzbilder" (reference photos), but WebFetch's markdown conversion did not surface a gallery or individual image URLs/alt text for this section — likely a JS-rendered gallery/lightbox that doesn't come through as markdown `<img>` tags. Follow-up with a browser-rendering tool (e.g. Claude in Chrome) is recommended if the actual reference photos are needed for migration, since this method could not capture them.

### Section: Kontakt

**Heading:** Kontakt

**Body copy (verbatim):**

> Lassen Sie uns zusammensetzen und Ihr nächstes Projekt besprechen. Dafür rufen Sie mich einfach an. Ich bin für Sie unter der Handynummer 0163/4310646 von 8.00 bis 18.00 Uhr für Sie erreichbar. Oder senden Sie mir Ihre Nachricht per E-Mail an fliesenerlich@hotmail.com
>
> Alternativ können Sie gern das unten stehende Formular ausfüllen und Ihr Anliegen schildern.

**Contact form:** The page includes an inline contact form below this copy. WebFetch's markdown conversion could not resolve individual field labels, placeholders, or the submit button text (forms typically don't survive markdown conversion) — only its presence and general purpose ("Formular ausfüllen und Ihr Anliegen schildern") could be confirmed. A browser-based capture would be needed to transcribe the exact field labels.

### Mobile menu

- "Direkt anrufen" — call link (`tel:+49163431064 6`)

### Footer

- "Login" (JS quick-login link, not user-facing content)
- "Impressum" → `/69`
- "Datenschutz" → `/70`
- "Webdesign by Homepage Atelier e.K" — credit line linking to https://homepageatelier.com/ (agency site attribution, not FliesenErlich copy)

---

## Notes / gaps for follow-up

- The site is built on a CMS ("Worldsoft CMS" per an icon URL surfaced during the fetch: `images.worldsoft-cms.info`), which explains the dynamic `/image.php?id=…` slider images and the JS-driven login/form elements.
- Referenzen gallery images and the Kontakt form's exact field set were not recoverable via WebFetch's markdown conversion (likely JS-rendered). If pixel/field-level fidelity is needed for migration, re-capture with a real browser render.
- No separate Über mich / Portfolio / Referenzen / Kontakt pages exist to fetch — confirmed via the navigation markup, which points all four at anchors on `/`.
