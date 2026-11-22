# Kadence dynamic content and ACF reference

Purpose: explain how Kadence Blocks Pro dynamic content works end to end (sources, fields, editor controls, rendering, ACF, conditional display, limits) and give exact native configurations for common patterns.

Versions studied: Kadence Blocks Pro 2.8.16, Kadence Blocks 3.9.1, Kadence Theme Kit Pro 1.2.6 (Elements), Kadence Theme 1.6.0. ACF behaviour is read from Kadence's calls into ACF (`get_field`, `get_field_object`, `acf_get_field_groups`); ACF source itself was not studied.

Contents
1. Tags and terms
2. Architecture in one page
3. Sources: current post, another post, relationship, repeater row
4. Field groups and field list per control type (from code)
5. Which block attributes accept dynamic content
6. Editor controls and the saved markup
7. Before, After, Fallback, Image Size
8. ACF integration (field types, return formats, groups, options pages, relationship, repeater)
9. Conditional Display rules
10. Preview in Elements, Advanced Pages and Query cards
11. Frontend rendering (filters, file:line)
12. Query Loop (Adv) and query cards
13. Limitations and when custom code is needed
14. Extension hooks
15. Worked examples

## 1. Tags and terms

Tags: `[code]` installed source with `path:line` (relative to the plugin folder), `[runtime]` runtime capture, `[docs]` official docs only, `[unverified]` not confirmed (check named). Everything in this file needs Kadence Blocks Pro `[Pro]` unless marked free. Element features need Kadence Theme Kit Pro `[Theme Kit Pro]`.

Terms used in code:
- **field**: `group|field`, for example `post|post_title`, `author|author_name`.
- **para**: the meta key selector for custom fields, for example `acf_meta|my_field`, `acf_option|my_field`, or `kb_custom_input` (then the key is in **custom**).
- **source**: empty or `current` = current post; a number = that post ID; for repeaters `current|acf_repeater|<repeater_name>`.
- **relate / relcustom**: the relationship field used to jump to a related post.

## 2. Architecture in one page

| Piece | What it does | Source |
|---|---|---|
| `Kadence_Blocks_Pro_Dynamic_Content` | Field lists for the editor, value lookup (`get_content`, `get_field_content`), frontend replacement in `render_block`, shortcode `[kb-dynamic]`, save-time sanitising | `[code] kadence-blocks-pro/includes/dynamic-content/class-kadence-blocks-pro-dynamic-content.php:102-133` |
| `Kadence_Blocks_Dynamic_Content_Controller` | REST routes the editor uses for previews and field pickers, namespace `kbp-dynamic/v1` (`render`, `link_label`, `input_label`, `image_render`, `image_data`, `gallery_data`, `custom_fields`, `list_data`, `html_data`, `repeaters`, `repeater_data`). Permission: `edit_posts` | `[code] kadence-blocks-pro/includes/class-kadence-blocks-dynamic-content-controller.php:168-333`; endpoint names `[code] ...dynamic-content.php:1591-1623` |
| ACF adapter | `kbp_dynamic_content_acf()` wraps `get_field()` and formats by type | `[code] kadence-blocks-pro/includes/dynamic-content/inc/acf.php:24-96` |
| Format helpers | image, background, gallery formatting | `[code] .../inc/image-format.php`, `background-format.php`, `gallery-format.php` |
| Other providers | Meta Box (`mb_meta`, `mb_option`, `mb_repeater`), Pods (`pod_meta`, `pod_option`), WooCommerce (`woo`), The Events Calendar (`tec`) | `[code] .../inc/metabox.php`, `pods.php`, `woo.php`, `tec.php` |
| Editor attributes | `kadenceDynamic` (object keyed by attribute slug) and `kadenceConditional` added to blocks with `ktdynamic` support | `[code] kadence-blocks-pro/dist/early-filters.js` |
| Repeater blocks | `kadence/repeater` + `kadence/repeatertemplate` loop ACF/Meta Box repeater rows | `[code] kadence-blocks-pro/includes/blocks/class-kadence-blocks-pro-repeatertemplate-block.php:75-139` |
| Dynamic HTML / Dynamic List blocks | Standalone dynamic blocks | `[code] .../blocks/class-kadence-blocks-pro-dynamichtml-block.php`, `...dynamiclist-block.php` |

Rendering is server side on the front end. In the editor, values come from the REST routes using a preview post.

## 3. Sources

| Source setting | Meaning | Source |
|---|---|---|
| Current Post (empty or `current`) | `get_the_ID()` at render time. Inside a loop (Query Loop (Adv), theme archive loop, Element in loop) this is the loop post | `[code] ...dynamic-content.php:3031-3042` |
| A specific post ("Select Dynamic Source", numeric ID) | Reads from that post. The ID is stored in block attributes | `[code] ...dynamic-content.php:3037-3039`; post picker REST `/kbpp/v1/post-select` `[code] kadence-blocks-pro/includes/init.php:120` |
| Meta Relationship group | Takes the current (or chosen) post, reads a relationship / post object field (`relate`), and switches to the first related post ID, then reads the chosen field there | `[code] ...dynamic-content.php:2985-3028`; ACF relationship returns first item `[code] .../inc/acf.php:77-90` |
| Repeater context ("Use Repeater Context") | Reads a sub field of the current row of the parent Repeater block | `[code] ...dynamic-content.php:3635-3700` |
| Archive | Uses `get_queried_object_id()` (the current term/archive), not the loop post | `[code] ...dynamic-content.php:3286-3291` |
| Author | Author of the current post; on author archives the queried author | `[code] ...dynamic-content.php:3176-3200` |
| Current User | `wp_get_current_user()` | `[code] ...dynamic-content.php:3455-3527` |
| Site | Site options, logo, page title, ACF options pages | `[code] ...dynamic-content.php:3337-3453` |

Visibility guard: post fields only render when the post is publicly viewable or the viewer can `read_post`, and not password protected (filter `kadence_dynamic_enable_password_content`) `[code] ...dynamic-content.php:3043`. Author fields additionally need `post_status` publish and post type `author` support `[code] ...dynamic-content.php:3194`.

## 4. Field groups and field list per control type

Each control type has its own list. Values are `group|field`. Lines are `[code] kadence-blocks-pro/includes/dynamic-content/class-kadence-blocks-pro-dynamic-content.php`.

| Group (label) | Text (1700) | HTML (1967) | Link (2472) | URL (2573) | Image (2790) | Background (2617) | Gallery (2746) / List (2702) | Form input (2169) | Conditional (2317) |
|---|---|---|---|---|---|---|---|---|---|
| Post | post_title, post_url, post_excerpt, post_id, post_date, post_date_modified, post_featured_image_url, post_type, post_status, post_custom_field | post_title, post_content, post_excerpt, post_date, post_date_modified, post_custom_field | post_url, post_featured_image_url, post_custom_field | post_custom_field | post_featured_image, post_custom_field | post_featured_image_url, post_custom_field | post_custom_field | same as Text | post_custom_field, post_title, post_url, post_id, post_date, post_date_modified, post_featured_image_url, post_type, post_status, has_taxonomy |
| Archive | archive_title, archive_url, archive_description, archive_custom_field | archive_title, archive_description, archive_custom_field | archive_url, archive_custom_field | archive_custom_field | archive_custom_field | archive_custom_field | archive_custom_field | | archive_title, archive_url, archive_custom_field |
| Site | site_title, site_tagline, site_url, page_title, user_info (current user display name), custom_setting | same | site_url, custom_setting | | logo, custom_setting | logo_url, custom_setting | custom_setting | same as Text | |
| Media | media_url, media_title, media_caption, media_description, media_alt_text, media_filename, media_post_url, media_custom_field | | media_url, media_post_url, media_custom_field | media_custom_field | media_url, media_custom_field | media_url, media_custom_field | | | |
| Author | author_name, author_first_name, author_last_name, author_info, author_custom_field | same | author_url, author_custom_field | | author_image, author_custom_field | author_image_url, author_custom_field | | | author_name, author_first_name, author_last_name, author_custom_field |
| Current User (`user`) | first_name, last_name, display_name, email, bio, website, username, id, user_custom_field | same | | | | | | same (listed first) | user_logged_in, user_role, display_name, first_name, last_name, user_custom_field |
| Meta Relationship | post_title, post_url, post_excerpt, post_featured_image_url, post_type, post_custom_field | post_title, post_content, post_excerpt, post_custom_field | post_url, post_featured_image_url, post_custom_field | post_custom_field | post_featured_image, post_custom_field | post_featured_image_url, post_custom_field | post_custom_field | post_title, post_url, post_excerpt, post_type, post_custom_field | |
| Time | time_current_year, time_current_month, time_current_day | same | | | | | | | |
| Repeater | | | | | | | | | repeater_custom_field |
| Comments | (commented out) | | | | | | | | count |
| URL | | | | | | | | | url_path, url, url_query_param |
| WooCommerce (only if active) | _price, _sale_price, _regular_price, _average_rating (3944-3968) | | | | | | | | |

Notes `[code]`:
- `post_date` uses the site date format; there is no per-block date format option (3048-3053).
- `post_content` runs `the_content` with the global post switched to the source post (3072-3089).
- `has_taxonomy` takes `para` = `taxonomy` or `taxonomy|term` (3090-3100).
- `user_role` with a condition value returns that role if the user has it, so "equals editor" works for multi-role users (3488-3495).
- Time values use PHP `date()` (server timezone), not the WordPress timezone (3738-3745).
- URL group sanitises `REQUEST_URI` and query params with `sanitize_text_field` (3753-3765).
- `custom_setting` with a typed key reads `get_option()`; saving such a field is stripped unless the editor has `manage_options`, and these keys are always blocked: prefixes `kadence_blocks_`, `stellarwp_uplink_license_`, `auto_update_core_`, and `secret`, `mailserver_pass`, `active_plugins`, `wp_user_roles` and others (3980-4157).

## 5. Which block attributes accept dynamic content

From `dynamicAttribute` props in the block editors `[code] kadence-blocks/dist/blocks-*.js`, `kadence-blocks-pro/dist/blocks-*.js`, and the PHP render handlers.

| Block | Attribute slug(s) in `kadenceDynamic` | Kind | Frontend handler |
|---|---|---|---|
| Advanced Text (`kadence/advancedheading`) | `content`, `link` | text (replace mode), link | inline span regex `...dynamic-content.php:1311-1363`; link via shortcode `1265-1285` |
| Single Button (`kadence/singlebtn`) | `text`, `link` | text, link | same |
| Advanced Button (`kadence/advancedbtn`) | `text`, `link` appear in its editor file, but the wrapper has no `ktdynamic` support `[runtime]`, so set dynamic values on each inner Single Button | | |
| Advanced Image (`kadence/image`) | `url`, `link` (also `urlSticky`, `urlTransparent` for header logo use) | image, link | `<img class="kb-img">` replaced `...dynamic-content.php:792-848` |
| Row Layout | `bgImg`, `overlayBgImg`, tablet/mobile background and overlay images, `backgroundVideo:0:local` | background | `kadence_blocks_rowlayout_render_block_attributes` `...dynamic-content.php:120, 486-550` |
| Section (`kadence/column`) | `backgroundImg:0:bgImg`, `backgroundImgHover:0:bgImg`, `overlayImg:0:bgImg`, `overlayImgHover:0:bgImg`, `link`, `linkTitle` | background, link | `kadence_blocks_column_render_block_attributes` `...dynamic-content.php:119` |
| Info Box | `mediaImage:0:url`, `link` | image, link | `...dynamic-content.php:1203-1262` |
| Advanced Gallery | `images`, `link` | gallery | `...dynamic-content.php:849-1089` |
| Video Popup | `background:0:img` (poster), `url` | image, URL | `...dynamic-content.php:1090-1148` |
| Icon / Single Icon / Icon List | `link` | link | shortcode in href |
| Countdown, Form, Advanced Form (submit/links) | `link` via URL control | link | shortcode in href |
| Advanced Form fields | `defaultValue` | form input | `[code] kadence-blocks/dist/blocks-advanced-form.js` |
| Google Maps | `location` | form input style text | `[code] kadence-blocks/dist/blocks-googlemaps.js` |
| Site Identity | `urlSticky`, `urlTransparent` | image | `[code] kadence-blocks/dist/blocks-identity.js` |
| Image Overlay (Pro) | `imgURL`, `link`, `title`, `subtitle` | image, link, text | `...dynamic-content.php:738-791` |
| Split Content (Pro) | `mediaUrl`, `link` | image, link | `...dynamic-content.php:1149-1202` |
| Dynamic HTML (Pro block) | block attributes `field`, `source`, `metaField`, `customMeta` | html | block class |
| Dynamic List (Pro block) | `type`, `tax`, `metaField`, `customMeta` | list | block class |

Not covered: core blocks (Paragraph, Heading, Image) have no Kadence dynamic support. Use Advanced Text and Advanced Image.

## 6. Editor controls and the saved markup

Two ways to put dynamic text in a text block:

1. **Block-level Dynamic Content** (Advanced Text, buttons). Toolbar button "Dynamic Content" opens the picker; settings are stored in `kadenceDynamic.<slug>` (`enable`, `source`, `field`, `custom`, `para`, `before`, `after`, `fallback`, `relate`, `relcustom`, `useRepeaterContext`, `shouldReplace`) `[code] kadence-blocks-pro/dist/blocks.js` (`dynamicInlineReplaceControl`, `dynamicTextControl`). The block content is replaced by one span: `<span data-field="post|post_title" ... class="kb-inline-dynamic">…</span>` with `data-source`, `data-field`, `data-para`, `data-custom`, `data-fallback`, `data-before`, `data-after`, `data-relate`, `data-relcustom`, `data-userepeatercontext` as needed `[code] kadence-blocks-pro/dist/blocks.js`. "Dynamic Replace Mode" (block sidebar, Advanced) toggles `shouldReplace`; inside a query card it is forced on `[code] kadence-blocks-pro/dist/blocks.js`.
2. **Inline insert** (any rich text in Kadence text blocks). Rich text format `kadence/insert-dynamic`, title "Insert Dynamic Content", tag `span`, class `kb-inline-dynamic`, attributes `data-source`, `data-field`, `data-para`, `data-fallback`, `data-custom`, `data-relate`, `data-relcustom`, `data-showall` `[code] kadence-blocks-pro/dist/blocks.js` (`registerFormatType`). This format has no Before/After attributes; type them as normal text around the span. The span text saved is the preview value.

The server regex only matches spans whose `data-*` attributes come before `class` `[code] ...dynamic-content.php:1313`. Hand-written markup must keep that order. When replicating editor output in scripts, set both the span and `kadenceDynamic` exactly as the editor saves them.

Links and URLs: the dynamic link control writes a `[kb-dynamic source='…' field='…' para='…' …]` shortcode string into the link attribute (the `href`) and stores settings in `kadenceDynamic.link` `[code] kadence-blocks-pro/dist/blocks.js` (string built as `"[kb-dynamic"`). Labels: "Dynamic Link", "Before link", "After link", "Fallback Link"; for URL inputs "Dynamic URL", "Before URL", "After URL", "Fallback URL".

Images and backgrounds: dynamic icon next to the image picker; labels "Dynamic Image", "Dynamic Background Image", "Dynamic Gallery"; Advanced section has "Image Size" (or "Images Size") and "Fallback Image URL" `[code] kadence-blocks-pro/dist/blocks.js`.

Picker labels: "Select Dynamic Source" (Current Post or a chosen post), field dropdown grouped as in section 4, "Custom Field" (meta key list from the custom fields REST route), "Relationship Source", "Use Repeater Context", "Repeater Field", "Repeater Sub Field Key" `[code] kadence-blocks-pro/dist/blocks.js` strings.

Custom field list in the picker `[code] kadence-blocks-pro/includes/class-kadence-blocks-dynamic-content-controller.php:2398-2600`:
- ACF groups filtered by location: Post/Relationship excludes groups located on attachments, taxonomies, comments, widgets, menus, users; Archive shows taxonomy groups; Author and User show user groups; Site shows options page groups; Media shows attachment groups (2426-2473).
- Post field groups are matched to the preview post (`acf_get_field_groups( post_id )`) unless the source is "ignore source" (2407-2411).
- Then non-ACF meta keys of the post (keys starting with `_` hidden) (2536-2560).
- "Custom Input" (`kb_custom_input`) lets you type any meta key.

## 7. Before, After, Fallback, Image Size

Logic in `get_content()` `[code] ...dynamic-content.php:2878-2942`:
- Arrays are joined with `", "` for text (2898-2905). The shortcode joins with `","` (3918-3925).
- **Fallback** applies when the value is empty. For image type it becomes the image URL (2906-2912).
- **Before** and **After** are added to any non-array value, even when the value and fallback are empty (2913-2918). An empty field with Before "By" still prints "By". Hide the block with Conditional Display "Not Empty" when that matters.
- For **image** and **background** types, the `before` setting is the image size, not text ("Image Size" control writes `before`) `[code] kadence-blocks-pro/dist/blocks.js`; used at `...dynamic-content.php:3148-3168` and `inc/acf.php:29-37`. Background ignores After.
- Leading and trailing spaces in `data-before` / `data-after` are kept at render time (comment at `...dynamic-content.php:1326`). Whether the editor input keeps a plain leading space is `[unverified]`; a no-break space is the safe choice.
- Core text fields are filtered with `wp_kses_post`; ACF text values are returned as ACF formats them. Keep editor roles tight (`limitations.md` §4).

## 8. ACF integration

### 8.1 How values are read
- Field key format: `acf_meta|<field_name>` for post, term, user and relationship sources; `acf_option|<field_name>` for options pages `[code] kadence-blocks-pro/includes/class-kadence-blocks-dynamic-content-controller.php:1795-1836`.
- Lookup: `get_field( name, post_id )`, or `get_field( name, 'option' )` for `acf_option` `[code] .../inc/acf.php:26-28`. So ACF formatting (return format, wpautop, etc.) applies.
- Object IDs: post ID; author `user_<id>` `[code] ...dynamic-content.php:3267-3269`; archive term `<taxonomy>_<term_id>` from the queried object `[code] ...dynamic-content.php:3321-3326`.

### 8.2 Field types offered per control
`[code] ...dynamic-content-controller.php:1954-2098`

| Control | ACF field types listed |
|---|---|
| Text / Conditional (default list) | text, textarea, number, range, email, url, password, wysiwyg, select, checkbox, radio, true_false, google_map, date_picker, time_picker, date_time_picker, color_picker |
| HTML (Dynamic HTML) | text, textarea, number, range, email, url, password, wysiwyg, oembed, select, date_picker, time_picker, date_time_picker |
| URL / Link | text, email, image, file, page_link, url, link |
| Image, Background | image |
| Gallery | gallery |
| List (Dynamic List) | select, checkbox |
| Relationship source | relationship, post_object |
| Repeater block source | group, repeater |
| Number | text, number, range |
| Query filter | default list plus button_group and others (2046-2073) |

Not listed anywhere: flexible_content, clone (except inside groups), taxonomy, user, file (except URL), button_group (except filters), oembed (except HTML). Use "Custom Input" with the raw meta key only when the stored raw value is usable as is.

### 8.3 Return formats `[code]`
- Image: array (`ID` or `id`), numeric ID, or URL string all work; output gives URL, width, height, alt and attachment ID `[code] .../inc/image-format.php:21-85`. Background uses the same three formats but checks IDs with a strict integer test, so an ID stored as a numeric string through "Custom Input" may fail `[code] .../inc/background-format.php:15-60`.
- Gallery: array of image arrays or IDs `[code] .../inc/gallery-format.php`.
- Link field: URL type takes `['url']`; title and target are not used `[code] .../inc/acf.php:38-44`. Set target and rel in the button's own settings.
- Google Map: returns the `address` string `[code] .../inc/acf.php:91-93`, `...dynamic-content.php:4171-4185`.
- Select / checkbox in Dynamic List: values become list items (uses `value` of label/value arrays) `[code] .../inc/acf.php:45-76`. In text controls, arrays are joined with commas.
- True/false: returns boolean; useful mainly in Conditional Display.

### 8.4 Groups
ACF group sub fields are offered as `acf_meta|<group>_<sub>` and read with that combined name `[code] ...dynamic-content-controller.php:1785-1792`. Reading `get_field('<group>_<sub>')` relies on ACF's stored meta name `[unverified]`; test once per project.

### 8.5 Options pages
Fields in groups located on an ACF options page are offered as "Options:<label>" with `acf_option|name` `[code] ...controller.php:1795-1801`. Pick them under Site > "Site Custom Setting" (Site group only lists options-page groups, 2441-2445) or under Post Custom Field. Saving a `site|custom_setting` field with a typed key needs `manage_options` (section 4 notes).

### 8.6 Relationship and post object
Choose the field group "Meta Relationship", then "Relationship Source" = the ACF relationship or post object field. Only the first related post is used `[code] .../inc/acf.php:77-90`, `...dynamic-content.php:2999-3027`. To list many related posts, use Query Loop (Adv) with a related query or custom query args `[unverified]` (`_kad_query_related` meta exists `[code] kadence-blocks-pro/includes/query/query-cpt.php:284-299`).

### 8.7 Repeater support
- Use the **Repeater** block. Set its source to the ACF repeater; source format `current|acf_repeater|<name>` (or `<post_id>|acf_repeater|<name>`) `[code] ...repeatertemplate-block.php:88-104`, `...dynamic-content.php:3778-3813`.
- Rows come from `get_field( name, post )`; each row renders the template with context `kadence/repeaterRow` (index) and `kadence/repeaterRowData` and is wrapped in `<li>` `[code] ...repeatertemplate-block.php:106-133`.
- Inside the template, turn on "Use Repeater Context" on each dynamic control and pick the sub field (`acf_repeater|<sub>`) `[code] ...dynamic-content.php:3635-3700`.
- Sub field formatting by control type: text (kses), url (`['url']` for link arrays), image (image format, size from `before`), background (sizes large, medium, thumbnail, medium_large or full), gallery, html/conditional raw value (3660-3696).
- Conditional Display inside rows: group "Repeater" > `repeater_custom_field` with the sub field key in "Repeater Sub Field Key" `[code] ...dynamic-content.php:2365-2370, 630`.
- Unique IDs of blocks with dynamic data inside loops get the row index or post ID appended, so per-row CSS stays separate `[code] ...dynamic-content.php:1294-1309`.

## 9. Conditional Display rules

Attribute and evaluation `[code] kadence-blocks-pro/includes/dynamic-content/class-kadence-blocks-pro-dynamic-content.php:561-677`.

- Editor: block sidebar, Advanced tab, "Conditional Display" > "Enable Conditional Display". Per condition: "Conditional Source" (Current Post or a chosen post), "Conditional Field" (list in section 4, Conditional column), "Custom Field" / taxonomy picker as needed, "Conditional Type" (compare), "Condition" value. "Add Condition" and "Logic Operator" AND / OR `[code] kadence-blocks-pro/dist/blocks.js`.
- Blocks: all with `ktdynamic` support except form fields (list in `blocks-pro.md` 5.2) `[runtime]`.
- Compare types `[code] ...dynamic-content.php:649-676`; labels `[code] kadence-blocks-pro/dist/blocks.js`:

| Value | Label | Test |
|---|---|---|
| `not_empty` (default) | Not Empty | `! empty( value )` |
| `is_empty` | Empty | `empty( value )` |
| `is_true` | True | `value == true` |
| `is_false` | False | `value == false` |
| `equals` | = | loose `==` |
| `not_equals` | != | loose `!=` |
| `equals_or_greater` | >= | `>=` |
| `equals_or_less` | <= | `<=` |
| `greater` | > | `>` |
| `less` | < | `<` |
| `contains` | Contains | substring, case sensitive |
| `not_contains` | Doesn't Contain | not substring |

- Logic: AND shows the block when all conditions pass; OR when any passes (597-608). Old single-condition data is migrated on the fly (565-581).
- Condition values are read with `force-string`, so arrays are joined with ", " before comparing (646, 2898-2905).
- `relate` is not passed when evaluating conditions, so relationship-based conditions are not supported (632-644).
- Hidden blocks return an empty string in `render_block`; nothing is printed (699-701). The editor still shows the block, with the class `kadence-has-conditional-display` `[code] kadence-blocks-pro/dist/blocks.js`.
- A logged-out visitor and `user_logged_in`: the guard at 3457 is written as `! 'user_logged_in' === $field`, which is always false, so user fields still evaluate (empty values) for guests. `user_logged_in` returns `is_user_logged_in()` (3464-3466). Result is correct, the guard is just ineffective.
- Free alternative (no data rules): Row Layout logged in / logged out / role visibility `[code] kadence-blocks/includes/class-kadence-blocks-frontend.php:101-169`. Theme Kit Pro Elements have their own display, user and device rules (meta `_kad_element_show_conditionals`, `_kad_element_hide_conditionals`, `_kad_element_user_conditionals`, `_kad_element_device_conditionals`, `_kad_element_expires`) `[code] kadence-pro/dist/elements/elements-init.php:2221-2222` (and the register_meta list near 3556); Elements rules do not appear to include custom field conditions `[unverified]` (check `get_display_options()` in that file).

## 10. Preview in Elements, Advanced Pages and Query cards

- Default preview: the latest post, filter `kadence_blocks_pro_dynamic_content_preview_post` `[code] kadence-blocks-pro/includes/init.php:113-125`.
- Elements: each Element stores `_kad_element_preview_post` and `_kad_element_preview_post_type`; passed to the editor as `previewPostID` / `previewPostType`, filters `kadence_elements_dynamic_content_preview_post` and `..._post_type`. Without a saved preview it uses the latest post `[code] kadence-pro/dist/elements/elements-init.php:2275-2310` `[Theme Kit Pro]`. Set it in the Element's settings panel (Preview setting) so the editor shows real data. Editor labels "*Using Previewing Post" and "*Previewing Latest Post" show which applies `[code] kadence-blocks-pro/dist/blocks.js`.
- Advanced Pages have the same pair `_kad_adv_page_preview_post` `[code] kadence-pro/dist/advanced-pages/advanced-pages-init.php:519-521`.
- Query cards store `_kad_query_card_preview_post_type` `[code] kadence-blocks-pro/includes/query/query-card-cpt.php:581`. Which post the card editor previews `[unverified]`; check in the editor.
- Editor previews come from REST (`/kbp-dynamic/v1/*`), not from the frontend renderer. Front end output is the source of truth; compare both.

## 11. Frontend rendering

All in `kadence-blocks-pro/includes/dynamic-content/class-kadence-blocks-pro-dynamic-content.php` unless noted `[code]`.

| Step | Hook / function | Line |
|---|---|---|
| Register shortcode `kb-dynamic` | `add_shortcode` | 116 |
| Main pass on every block | `render_block` filter, priority 12, `render_blocks()` | 117, 686 |
| Skip in admin | `is_admin()` returns content unchanged | 687-689 |
| Conditional Display | `should_conditionally_hide_block()` | 699-701, 561-611 |
| Image replacement (Image Overlay, Advanced Image, Gallery, Video Popup poster, Split Content, Info Box) | regex on the block's `<img>` | 738-1262 |
| Link / URL shortcodes in query blocks or outside `the_content` | `do_shortcode( $block_content )` | 1265-1285 |
| AOS assets for animated blocks | enqueue `kadence-aos` | 1286-1293 |
| Unique ID suffix inside loops | post ID or repeater index appended | 1294-1309 |
| Inline text spans | regex on `kb-inline-dynamic` spans | 1311-1363 |
| Background images (Row, Section) | `kadence_blocks_rowlayout_render_block_attributes`, `kadence_blocks_column_render_block_attributes` | 119-120, 486-550 |
| Image props (Info Box, Image Overlay, Split Content) | `kadence_blocks_*_render_block_attributes` | 121-123, 406-479 |
| Video popup custom ratio | `kadence_blocks_video_render_block_attributes` | 124, 334 |
| Inline CSS for blocks in a query | `kadence_blocks_render_head_css`, `kadence_blocks_force_render_inline_css_in_content`, `kadence_blocks_build_render_unique_id` | 125-127 |
| Save-time sanitising of `site|custom_setting` | `wp_insert_post_data` | 130, 3980-4119 |
| Restrict Content Pro access | `kadence_dynamic_enable_password_content` | 132, 4164-4166 |

Elements `[Theme Kit Pro]`: blocks with `kadenceDynamic` inside Elements on custom hooks or `replace_loop_content` are marked to render CSS inline, and `kadence_blocks_in_query_block` returns true for them, so per-post backgrounds work in loops `[code] kadence-pro/dist/elements/elements-init.php:168, 1780-1792, 1853-1869`.

Image output note: the Advanced Image replacement prints a plain `<img>` with `src`, `alt`, `width`, `height` and `wp-image-<id>` class, no `srcset` `[code] ...dynamic-content.php:838-842`. Whether core later adds `srcset`/`loading` depends on the context running `wp_filter_content_tags` (`the_content` does; Element hooks may not) `[unverified]`; inspect the front-end HTML.

## 12. Query Loop (Adv) and query cards

- Each result runs `$query->the_post()` and the block context `postId`/`postType` is set, then the card template is rendered with `do_blocks` and `do_shortcode` `[code] kadence-blocks-pro/includes/query/query-rest-api.php:320-341`. So Source "Current Post" means the card's post.
- Kadence blocks in a card get `inQueryBlock` true, which turns on Replace mode and per-post unique IDs `[code] query-rest-api.php:1110-1124`; `...dynamic-content.php:1294-1309`.
- Card template from an Element or Woo template also works `[code] query-rest-api.php:1142-1150`.
- Archive pages: the query can inherit the main query (`inherit` in `_kad_query_query`) `[code] kadence-blocks-pro/includes/query/query-cpt.php:338, 361`, `query-rest-api.php:105-115`.

## 13. Limitations and when custom code is needed

| Limit | Source | Native workaround | When custom code is justified |
|---|---|---|---|
| Before/After print even when the value is empty | `...dynamic-content.php:2913-2918` | Conditional Display Not Empty on the block | never for this alone |
| Only the first post of a relationship field | `inc/acf.php:77-90` | Query Loop (Adv) with related/meta query | many related items with custom ordering beyond the query UI |
| Archive ACF term fields read the queried term, not a term in a loop | `...dynamic-content.php:3321-3326` | Only use on term archive templates | term cards in a term grid |
| Flexible content not supported | type lists `...controller.php:1954-2098` | Repeater with a layout select sub field + Conditional Display "equals" per row | complex layouts |
| Nested repeaters: the template source is the top-level field of the post | `...repeatertemplate-block.php:88-104` | flatten data | nested data |
| Conditions cannot use relationship sources | `...dynamic-content.php:632-644` | compute a flag on the post | add a computed meta flag (small plugin code) |
| No date format option | `...dynamic-content.php:3048-3053` | ACF date picker return format | different formats per block |
| Time group uses server timezone | 3738-3745 | none | if server timezone differs from site timezone |
| Core blocks lack dynamic support | supports in runtime | use Advanced Text / Advanced Image | never |
| Dynamic Advanced Image lacks `srcset` | 838-842 | use dynamic background or Query card | responsive image needs, after checking output |
| Author fields need a published post with author support | 3194 | | |
| Without Blocks Pro active, inline spans keep their saved preview text | inline span saved with preview value `[code] kadence-blocks-pro/dist/blocks.js` | keep Pro active | |

## 14. Extension hooks

All `[code]` in `class-kadence-blocks-pro-dynamic-content.php` unless noted:
- Add options to pickers: `kadence_block_pro_dynamic_text_fields_options` (1962), `..._html_fields_options` (2164), `..._input_fields_options` (2312), `..._conditional_fields_options` (2467), `..._link_fields_options` (2568), `..._url_fields_options` (2612), `..._background_field_options` (2697), `..._list_fields_options` (2741), `..._gallery_fields_options` (2785), `..._image_fields_options` (2870).
- Provide values for a new field: `kadence_dynamic_content_core_{group}_{field}_render` (for example 3170, 3277, 3334, 3452, 3524, 3609, 3632, 3748); non-core origin `kadence_dynamic_content_{origin}_render` (3768); final value `kadence_dynamic_content_render` (3770).
- Change source or row: `kadence_dynamic_item_id`, `kadence_dynamic_repeater_row` (2895-2896).
- Custom field picker: `kadence_blocks_dynamic_custom_fields`, `kadence_blocks_dynamic_custom_fields_captured` `[code] ...controller.php:2532-2533`.
- Loop detection: `kadence_blocks_in_query_block` (697).
- Fallback images in the editor: `kadence_blocks_pro_dynamic_image_no_content`, `kadence_blocks_pro_dynamic_gallery_no_content` (1616-1617).

Use these only when a native field cannot express the data (for example a computed boolean for Conditional Display).

## 15. Worked examples

Each example gives the native setup. Status: settings and stored values are confirmed from code `[code]`; none were clicked through in a live editor for this study, so editor wording and placement are `[unverified UI]` unless stated.

### 15.1 Tutorial title from the current post
- Where: single-post Element `[Theme Kit Pro]` or the post template.
- Block: Advanced Text, tag H1.
- Toolbar "Dynamic Content" > Source: Current Post > Field: Post > Post Title.
- Stored: `kadenceDynamic.content` = `{ enable: true, field: "post|post_title", source: "" , shouldReplace: 1 }`; content = `<span data-field="post|post_title" class="kb-inline-dynamic">…</span>` `[code]` (generator in `kadence-blocks-pro/dist/blocks.js`, renderer `...dynamic-content.php:1311-1363`, value `3045-3047`).
- Status: `[code]`, `[unverified UI]`.

### 15.2 Featured image
- Block: Advanced Image. Click the dynamic icon on the image ("Dynamic Image") > Post > Featured Image (`post|post_featured_image`). Advanced > Image Size (stored as `before`), optional Fallback Image URL.
- Stored: `kadenceDynamic.url` with `enable`, `field`, `before` (size).
- Render: `<img class="kb-img">` replaced with the attachment URL, size, alt and `wp-image-<id>` `[code] ...dynamic-content.php:792-848, 3154-3168`.
- Alternative for a hero: Row Layout background, dynamic background `post|post_featured_image_url` `[code] 2623, 486-550`.
- Status: `[code]`, `[unverified UI]`; check `srcset` in output (section 11).

### 15.3 ACF field inside a query card
- Query Loop (Adv) > edit the Query Card. Add Advanced Text. Toolbar "Dynamic Content" > Source: Current Post > Field: Post > Post Custom Field > Custom Field: the ACF field (`acf_meta|<field_name>`).
- Stored: `kadenceDynamic.content` = `{ enable: true, field: "post|post_custom_field", para: "acf_meta|<field_name>", shouldReplace: 1 }` and the matching span with `data-field` and `data-para`.
- Render: card loop sets the current post with `the_post()` `[code] query-rest-api.php:323`; ACF read with `get_field( name, post_id )` `[code] inc/acf.php:28`.
- The field must belong to a group whose location matches the preview post, or it will not appear in the picker `[code] ...controller.php:2407-2411`. Use "Custom Input" with the field name if needed.
- Status: `[code]`, `[unverified UI]`.

### 15.4 Dynamic external button URL from ACF
- ACF field: URL (or Link) on the post type.
- Block: Advanced Button > Single Button. Link field > dynamic icon ("Dynamic Link") > Post > Post Custom Field > `acf_meta|<url_field>`. Set "Open in new tab" and rel (nofollow / sponsored) in the button's normal link settings.
- Stored: link attribute holds `[kb-dynamic field='post|post_custom_field' para='acf_meta|<url_field>' …]`; `kadenceDynamic.link` holds the settings `[code] kadence-blocks-pro/dist/blocks.js`.
- Render: `do_shortcode` resolves the href; Link field arrays use `url` `[code] ...dynamic-content.php:1265-1285`, `inc/acf.php:38-44`.
- Hide when empty: on the Single Button, Conditional Display > Post Custom Field `acf_meta|<url_field>` > Not Empty.
- Status: `[code]`, `[unverified UI]`.

### 15.5 Author info section
- Container: Row Layout or Section in a single-post Element.
- Avatar: Advanced Image, dynamic image Author > Author Image (`author|author_image`), Image Size thumbnail/medium/medium_large/large (only these sizes change the avatar size); alt is the author display name `[code] ...dynamic-content.php:3234-3250`.
- Name: Advanced Text, Dynamic Content Author > Author Display Name (`author|author_name`).
- Bio: Advanced Text with Author > Author Bio Info (`author|author_info`), or Dynamic HTML for formatted bio.
- Archive link: Single Button, Dynamic Link Author > Author URL (`author|author_url`).
- Extra profile fields: Author Custom Field with an ACF user field (`acf_meta|<name>`, read from `user_<id>`) `[code] 3267-3269`.
- Hide the section when there is no bio: "Author Bio Info" is not in the Conditional list, but Author > Author Custom Field with Custom Input `description` reads `get_the_author_meta( 'description' )` `[code] ...dynamic-content.php:3251-3257`. Use Conditional Type Not Empty.
- Status: `[code]`, `[unverified UI]`.

### 15.6 Reusable template Element with per-post content
- `[Theme Kit Pro]` Appearance > Kadence > Elements: create an Element, choose a hook (for example after content, or replace single content), set display rules to the post type, and set the Element Preview to a real post.
- Inside, every dynamic block uses Source: Current Post. The same Element then shows each post's own data.
- Preview meta: `_kad_element_preview_post` `[code] kadence-pro/dist/elements/elements-init.php:2275-2310`.
- Status: `[code]`, `[unverified UI]`.

### 15.7 Dynamic archive card
- Option A `[Theme Kit Pro]`: Element with hook "replace loop content" (`replace_loop_content`), which removes the theme's `Kadence\loop_entry` and renders the Element per post `[code] kadence-pro/dist/elements/elements-init.php:916-920`. Dynamic blocks use Current Post; their CSS renders inline per post `[code] 1780-1781, 1853-1858`.
- Option B: Query Loop (Adv) on the archive template with the query set to inherit the main query `[code] query-cpt.php:338`.
- Card contents: Advanced Image (featured image), Advanced Text (title with link: Dynamic Link Post URL), Dynamic List (taxonomy terms), Advanced Text (excerpt or an ACF field).
- Status: `[code]`, `[unverified UI]`.

### 15.8 Conditional affiliate disclosure
- ACF: true/false field on the post type, for example `has_affiliate_links`.
- Block: put the disclosure in a Section (or use one Advanced Text block). Core Paragraph cannot take conditions.
- Section sidebar > Advanced > Conditional Display > Enable. Conditional Source: Current Post. Conditional Field: Post > Post Custom Field. Custom Field: `acf_meta|has_affiliate_links`. Conditional Type: True.
- Stored: `kadenceConditional.postData` = `{ enable: true, logic: "AND", conditions: [ { source: "", field: "post|post_custom_field", para: "acf_meta|has_affiliate_links", custom: "", compare: "is_true", condition: "" } ] }` `[code] ...dynamic-content.php:561-611`.
- Result: off or never saved gives false or null, block not printed (`value == true` fails) `[code] 654-655, 699-701`.
- Status: `[code]`, `[unverified UI]`.
