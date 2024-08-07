## SCSS Variables

This is the list of all SCSS variables defined in the various style files used
by the Chameleon skin (although not all of the variables are actually used).

These variables may be modified to change the look of your wiki. However, you
should __not__ modify the style files of the Bootstrap framework or the
Chameleon skin directly. Instead use the methods described in
[Customization](customization.md).

The values given here are the final calculated values, the exact text of the
definition may be found in the style files.
Be aware that some variables may be defined several times over more than one
style file. In general, SCSS considers the first occurence of a `!default` value
as _the_ default value for a variable, discarding all subsequent `!default`
values it encounters. It then overwrites the value of the variable with
non-default values in the order of occurence in the SCSS code.

Some examples are provided below:
<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->

- [Grid breakpoints](#grid-breakpoints)
- [Link formats](#link-formats)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->


 Name                                                  | Value                                          
-------------------------------------------------------|----------------------
 $alert-bg-level                                       | -10
 $alert-border-level                                   | -9
 $alert-border-radius                                  | 0.25rem
 $alert-border-width                                   | 1px
 $alert-color-level                                    | 6
 $alert-link-font-weight                               | 700
 $alert-margin-bottom                                  | 1rem
 $alert-padding-x                                      | 1.25rem
 $alert-padding-y                                      | 0.75rem
 $badge-border-radius                                  | 0.25rem
 $badge-focus-width                                    | 0.2rem
 $badge-font-size                                      | 0.75
 $badge-font-weight                                    | 700
 $badge-padding-x                                      | 0.4em
 $badge-padding-y                                      | 0.25em
 $badge-pill-border-radius                             | 10rem
 $badge-pill-padding-x                                 | 0.6em
 $badge-transition                                     | color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out
 $black                                                | #000
 $blockquote-font-size                                 | 1.25rem
 $blockquote-small-color                               | #6c757d
 $blockquote-small-font-size                           | 0.8
 $blue                                                 | #007bff
 $body-bg                                              | #fff
 $body-color                                           | #212529
 $border-color                                         | #dee2e6
 $border-radius                                        | 0.25rem
 $border-radius-lg                                     | 0.3rem
 $border-radius-sm                                     | 0.2rem
 $border-width                                         | 1px
 $box-shadow                                           | 0 0.5rem 1rem rgba(0, 0, 0, 0.15)
 $box-shadow-lg                                        | 0 1rem 3rem rgba(0, 0, 0, 0.175)
 $box-shadow-sm                                        | 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075)
 $breadcrumb-active-color                              | #6c757d
 $breadcrumb-bg                                        | #e9ecef
 $breadcrumb-border-radius                             | 0.25rem
 $breadcrumb-divider                                   | /
 $breadcrumb-divider-color                             | #6c757d
 $breadcrumb-item-padding                              | 0.5rem
 $breadcrumb-margin-bottom                             | 1rem
 $breadcrumb-padding-x                                 | 1rem
 $breadcrumb-padding-y                                 | 0.75rem
 $btn-active-box-shadow                                | inset 0 3px 5px rgba(0, 0, 0, 0.125)
 $btn-block-spacing-y                                  | 0.5rem
 $btn-border-radius                                    | 0.25rem
 $btn-border-radius-lg                                 | 0.3rem
 $btn-border-radius-sm                                 | 0.2rem
 $btn-border-width                                     | 1px
 $btn-box-shadow                                       | inset 0 1px 0 rgba(255, 255, 255, 0.15), 0 1px 1px rgba(0, 0, 0, 0.075)
 $btn-disabled-opacity                                 | 0.65
 $btn-focus-box-shadow                                 | 0 0 0 0.2rem rgba(0, 123, 255, 0.25)
 $btn-focus-width                                      | 0.2rem
 $btn-font-family                                      | null
 $btn-font-size                                        | 1rem
 $btn-font-size-lg                                     | 1.25rem
 $btn-font-size-sm                                     | 0.875rem
 $btn-font-weight                                      | 400
 $btn-line-height                                      | 1.5
 $btn-line-height-lg                                   | 1.5
 $btn-line-height-sm                                   | 1.5
 $btn-link-disabled-color                              | #6c757d
 $btn-padding-x                                        | 0.75rem
 $btn-padding-x-lg                                     | 1rem
 $btn-padding-x-sm                                     | 0.5rem
 $btn-padding-y                                        | 0.375rem
 $btn-padding-y-lg                                     | 0.5rem
 $btn-padding-y-sm                                     | 0.25rem
 $btn-transition                                       | color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out
 $burgundy                                             | #9b1b2f
 $card-bg                                              | #fff
 $card-border-color                                    | rgba(0, 0, 0, 0.125)
 $card-border-radius                                   | 0.25rem
 $card-border-width                                    | 1px
 $card-cap-bg                                          | rgba(0, 0, 0, 0.03)
 $card-cap-color                                       | null
 $card-color                                           | null
 $card-columns-count                                   | 3
 $card-columns-gap                                     | 1.25rem
 $card-columns-margin                                  | 0.75rem
 $card-deck-margin                                     | 15px
 $card-group-margin                                    | 15px
 $card-img-overlay-padding                             | 1.25rem
 $card-inner-border-radius                             | calc(0.25rem - 1px)
 $card-spacer-x                                        | 1.25rem
 $card-spacer-y                                        | 0.75rem
 $caret-spacing                                        | 0.255em
 $caret-vertical-align                                 | 0.255em
 $caret-width                                          | 0.3em
 $carousel-caption-color                               | #fff
 $carousel-caption-width                               | 0.7
 $carousel-control-color                               | #fff
 $carousel-control-hover-opacity                       | 0.9
 $carousel-control-icon-width                          | 20px
 $carousel-control-next-icon-bg                        | url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 8 8'%3e%3cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3e%3c/svg%3e")
 $carousel-control-opacity                             | 0.5
 $carousel-control-prev-icon-bg                        | url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 8 8'%3e%3cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3e%3c/svg%3e")
 $carousel-control-transition                          | opacity 0.15s ease
 $carousel-control-width                               | 0.15
 $carousel-indicator-active-bg                         | #fff
 $carousel-indicator-height                            | 3px
 $carousel-indicator-hit-area-height                   | 10px
 $carousel-indicator-spacer                            | 3px
 $carousel-indicator-transition                        | opacity 0.6s ease
 $carousel-indicator-width                             | 30px
 $carousel-transition                                  | transform 0.6s ease-in-out
 $carousel-transition-duration                         | 0.6s
 $chambray                                             | #355b84
 $close-color                                          | #000
 $close-font-size                                      | 1.5rem
 $close-font-weight                                    | 700
 $close-text-shadow                                    | 0 1px 0 #fff
 $cmln-collapse-point                                  | 1105px
 $cmln-first-heading-margin-bottom                     | 1rem
 $cmln-first-heading-underline-color                   | rgba(0, 0, 0, 0.1)
 $cmln-first-heading-underline-width                   | 1px
 $cmln-grid-breakpoints                                | (xs: 0, sm: 576px, md: 768px, lg: 992px, cmln: 1105px, xl: 1200px, xxl: 1400px)
 $cmln-icon-margin                                     | 0.5rem
 $cmln-icons                                           | (go-btn: fas fa-share, search-btn: fas fa-search, navbar-toggler: fas fa-bars, navbar-tool-link: fas fa-asterisk, navbar-more-tools: fas fa-ellipsis-h, navbar-usernotloggedin: fas fa-user, navbar-userloggedin: fas fa-user, ca-addsection: fas fa-plus, ca-cargo-purge: fas fa-redo, ca-delete: fas fa-trash-alt, ca-edit: far fa-edit, ca-formedit: far fa-edit, ca-history: fas fa-history, ca-move: fas fa-location-arrow, ca-nstab-category: fas fa-layer-group, ca-nstab-concept: fas fa-puzzle-piece, ca-nstab-form: fas fa-address-card, ca-nstab-geojson: fas fa-globe, ca-nstab-help: fas fa-question, ca-nstab-image: far fa-file-image, ca-nstab-main: far fa-file, ca-nstab-mediawiki: fas fa-cogs, ca-nstab-project: fas fa-project-diagram, ca-nstab-rule: fas fa-ruler, ca-nstab-smw: fas fa-boxes, ca-nstab-special: fas fa-cogs, ca-nstab-template: fas fa-stamp, ca-nstab-user: far fa-user, ca-nstab-widget: fas fa-drafting-compass, ca-protect: fas fa-lock, ca-purge: fas fa-redo, ca-recreatedata: fas fa-database, ca-semantic_edit: fas fa-pen-fancy, ca-talk: far fa-comments, ca-unprotect: fas fa-lock, ca-unwatch: far fa-eye-slash, ca-ve-edit: far fa-edit, ca-view-foreign: far fa-images, ca-viewsource: fas fa-code, ca-watch: far fa-eye, feedlink: fas fa-rss, interlanguage-link-target: fas fa-flag, mw-navigation: fas fa-directions, n-Homepage: fas fa-home, n-IRC: fas fa-hashtag, n-Index: fas fa-th, n-List-of-files-with-duplicates: fas fa-check-double, n-Slack: fab fa-slack, n-Uncategorized-files: fas fa-object-ungroup, n-contributionscores: fas fa-user-tag, n-help-mediawiki: fas fa-question, n-help: fas fa-question, n-mainpage-description: fas fa-home, n-mainpage: fas fa-home, n-newfiles: fas fa-images, n-newimages: fas fa-seedling, n-newpages: fas fa-seedling, n-portal: fas fa-archway, n-randompage: fas fa-random, n-recentchanges: fas fa-backward, n-upload: fas fa-upload, p-lang-toggle: fas fa-language, p-navigation-toggle: far fa-compass, p-Page-Properties-toggle: fas fa-shapes,p-tb-toggle: fas fa-toolbox, pt-anoncontribs: fas fa-question, pt-anontalk: fas fa-comments, pt-createaccount: fas fa-user-plus, pt-login: fas fa-sign-in-alt, pt-logout: fas fa-sign-out-alt, pt-mycontris: fas fa-question, pt-mytalk: fas fa-comments, pt-notifications-alert: fas fa-bell, pt-notifications-notice: fas fa-inbox, pt-preferences: fas fa-sliders-h, pt-userpage: fas fa-home, pt-watchlist: far fa-eye, t-blockip: fas fa-user-slash, t-cargopagevalueslink: fas fa-thermometer-half, t-cite: fas fa-question, t-contributions: fas fa-user-edit, t-contributors: fas fa-user-edit, t-emailuser: fas fa-at, t-info: fas fa-info, t-log: fas fa-clipboard-list, t-permalink: fas fa-link, t-print: fas fa-print, t-recentchanges: fas fa-clock, t-recentchangeslinked: fas fa-backward, t-smwbrowselink: fas fa-compass, t-specialpages: fas fa-cogs, t-upload: fas fa-upload, t-userrights: fas fa-users, t-wb-concept-uri: fas fa-stroopwafel, t-whatlinkshere: fas fa-sitemap, t-wikibase: fas fa-stroopwafel)
 $cmln-link-format                                     | #1b599b none #10345a underline
 $cmln-link-formats                                    | (new: ('color': #9b1b2f, 'hover-color': #5a101b), stub: #1b599b none #10345a underline, extiw: #1b599b none #10345a underline, external: #1b599b none #10345a underline)
 $cmln-navbar-bg-color                                 | light
 $cmln-navbar-horizontal-collapse-point                | cmln
 $cmln-navbar-logo-height                              | 2.5rem
 $cmln-navbar-toggler-color                            | light
 $cmln-page-tools-font-size                            | 0.875rem
 $cmln-page-tools-item-margin                          | 1.5rem
 $cmln-page-tools-link                                 | #1b599b none #10345a underline
 $cmln-page-tools-link-new                             | ('color': #6c757d, 'hover-color': #494f54)
 $cmln-personal-tools-font-size                        | 0.875rem
 $cmln-personal-tools-item-margin                      | 1.5rem
 $cmln-personal-tools-link                             | #1b599b none #10345a underline
 $cmln-personal-tools-link-new                         | ('color': #6c757d, 'hover-color': #494f54)
 $cmln-search-bar-btn-color                            | light
 $cmln-search-bar-collapse-point                       | cmln
 $cmln-toc-entry-number-padding-right                  | 0.5rem
 $cmln-toc-group-margin-y                              | 0.25rem
 $cmln-toc-subgroup-margin-left                        | 0.5rem
 $cmln-toc-title-font-size                             | 1.25rem
 $cobalt                                               | #1b599b
 $code-color                                           | #e83e8c
 $code-font-size                                       | 0.875
 $colors                                               | ("blue": #007bff, "indigo": #6610f2, "purple": #6f42c1, "pink": #e83e8c, "red": #dc3545, "orange": #fd7e14, "yellow": #ffc107, "green": #28a745, "teal": #20c997, "cyan": #17a2b8, "white": #fff, "gray": #6c757d, "gray-dark": #343a40)
 $component-active-bg                                  | #007bff
 $component-active-color                               | #fff
 $container-max-widths                                 | (sm: 540px, md: 720px, lg: 960px, xl: 1140px)
 $custom-checkbox-indicator-border-radius              | 0.25rem
 $custom-checkbox-indicator-icon-checked               | url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e")
 $custom-checkbox-indicator-icon-indeterminate         | url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 4'%3e%3cpath stroke='%23fff' d='M0 2h4'/%3e%3c/svg%3e")
 $custom-checkbox-indicator-indeterminate-bg           | #007bff
 $custom-checkbox-indicator-indeterminate-border-color | #007bff
 $custom-checkbox-indicator-indeterminate-box-shadow   | none
 $custom-checkbox-indicator-indeterminate-color        | #fff
 $custom-control-gutter                                | 0.5rem
 $custom-control-indicator-active-bg                   | #b3d7ff
 $custom-control-indicator-active-border-color         | #b3d7ff
 $custom-control-indicator-active-box-shadow           | none
 $custom-control-indicator-active-color                | #fff
 $custom-control-indicator-bg                          | #fff
 $custom-control-indicator-bg-size                     | 50% 50%
 $custom-control-indicator-border-color                | #adb5bd
 $custom-control-indicator-border-width                | 1px
 $custom-control-indicator-box-shadow                  | inset 0 1px 1px rgba(0, 0, 0, 0.075)
 $custom-control-indicator-checked-bg                  | #007bff
 $custom-control-indicator-checked-border-color        | #007bff
 $custom-control-indicator-checked-box-shadow          | none
 $custom-control-indicator-checked-color               | #fff
 $custom-control-indicator-checked-disabled-bg         | rgba(0, 123, 255, 0.5)
 $custom-control-indicator-disabled-bg                 | #e9ecef
 $custom-control-indicator-focus-border-color          | #80bdff
 $custom-control-indicator-focus-box-shadow            | 0 0 0 0.2rem rgba(0, 123, 255, 0.25)
 $custom-control-indicator-size                        | 1rem
 $custom-control-label-disabled-color                  | #6c757d
 $custom-control-spacer-x                              | 1rem
 $custom-file-bg                                       | #fff
 $custom-file-border-color                             | #ced4da
 $custom-file-border-radius                            | 0.25rem
 $custom-file-border-width                             | 1px
 $custom-file-box-shadow                               | inset 0 1px 1px rgba(0, 0, 0, 0.075)
 $custom-file-button-bg                                | #e9ecef
 $custom-file-button-color                             | #495057
 $custom-file-color                                    | #495057
 $custom-file-disabled-bg                              | #e9ecef
 $custom-file-focus-border-color                       | #80bdff
 $custom-file-focus-box-shadow                         | 0 0 0 0.2rem rgba(0, 123, 255, 0.25)
 $custom-file-font-family                              | null
 $custom-file-font-weight                              | 400
 $custom-file-height                                   | calc(1.5em + 0.75rem + 2px)
 $custom-file-height-inner                             | calc(1.5em + 0.75rem)
 $custom-file-line-height                              | 1.5
 $custom-file-padding-x                                | 0.75rem
 $custom-file-padding-y                                | 0.375rem
 $custom-file-text                                     | (en: "Browse")
 $custom-forms-transition                              | background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out
 $custom-radio-indicator-border-radius                 | 0.5
 $custom-radio-indicator-icon-checked                  | url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e")
 $custom-range-thumb-active-bg                         | #b3d7ff
 $custom-range-thumb-bg                                | #007bff
 $custom-range-thumb-border                            | 0
 $custom-range-thumb-border-radius                     | 1rem
 $custom-range-thumb-box-shadow                        | 0 0.1rem 0.25rem rgba(0, 0, 0, 0.1)
 $custom-range-thumb-disabled-bg                       | #adb5bd
 $custom-range-thumb-focus-box-shadow                  | 0 0 0 1px #fff, 0 0 0 0.2rem rgba(0, 123, 255, 0.25)
 $custom-range-thumb-focus-box-shadow-width            | 0.2rem
 $custom-range-thumb-height                            | 1rem
 $custom-range-thumb-width                             | 1rem
 $custom-range-track-bg                                | #dee2e6
 $custom-range-track-border-radius                     | 1rem
 $custom-range-track-box-shadow                        | inset 0 0.25rem 0.25rem rgba(0, 0, 0, 0.1)
 $custom-range-track-cursor                            | pointer
 $custom-range-track-height                            | 0.5rem
 $custom-range-track-width                             | 1
 $custom-select-background                             | url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3e%3cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") no-repeat right 0.75rem center / 8px 10px
 $custom-select-bg                                     | #fff
 $custom-select-bg-size                                | 8px 10px
 $custom-select-border-color                           | #ced4da
 $custom-select-border-radius                          | 0.25rem
 $custom-select-border-width                           | 1px
 $custom-select-box-shadow                             | inset 0 1px 2px rgba(0, 0, 0, 0.075)
 $custom-select-color                                  | #495057
 $custom-select-disabled-bg                            | #e9ecef
 $custom-select-disabled-color                         | #6c757d
 $custom-select-feedback-icon-padding-right            | calc((1em + 0.75rem) * 3 / 4 + 1.75rem)
 $custom-select-feedback-icon-position                 | center right 1.75rem
 $custom-select-feedback-icon-size                     | calc(0.75em + 0.375rem) calc(0.75em + 0.375rem)
 $custom-select-focus-border-color                     | #80bdff
 $custom-select-focus-box-shadow                       | 0 0 0 0.2rem rgba(0, 123, 255, 0.25)
 $custom-select-focus-width                            | 0.2rem
 $custom-select-font-family                            | null
 $custom-select-font-size                              | 1rem
 $custom-select-font-size-lg                           | 1.25rem
 $custom-select-font-size-sm                           | 0.875rem
 $custom-select-font-weight                            | 400
 $custom-select-height                                 | calc(1.5em + 0.75rem + 2px)
 $custom-select-height-lg                              | calc(1.5em + 1rem + 2px)
 $custom-select-height-sm                              | calc(1.5em + 0.5rem + 2px)
 $custom-select-indicator                              | url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3e%3cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e")
 $custom-select-indicator-color                        | #343a40
 $custom-select-indicator-padding                      | 1rem
 $custom-select-line-height                            | 1.5
 $custom-select-padding-x                              | 0.75rem
 $custom-select-padding-x-lg                           | 1rem
 $custom-select-padding-x-sm                           | 0.5rem
 $custom-select-padding-y                              | 0.375rem
 $custom-select-padding-y-lg                           | 0.5rem
 $custom-select-padding-y-sm                           | 0.25rem
 $custom-switch-indicator-border-radius                | 0.5rem
 $custom-switch-indicator-size                         | calc(1rem - 4px)
 $custom-switch-width                                  | 1.75rem
 $cyan                                                 | #17a2b8
 $danger                                               | #dc3545
 $dark                                                 | #343a40
 $darker                                               | #ced4da
 $display-line-height                                  | 1.2
 $display1-size                                        | 6rem
 $display1-weight                                      | 300
 $display2-size                                        | 5.5rem
 $display2-weight                                      | 300
 $display3-size                                        | 4.5rem
 $display3-weight                                      | 300
 $display4-size                                        | 3.5rem
 $display4-weight                                      | 300
 $displays                                             | none, inline, inline-block, block, table, table-row, table-cell, flex, inline-flex
 $dropdown-bg                                          | #fff
 $dropdown-border-color                                | rgba(0, 0, 0, 0.15)
 $dropdown-border-radius                               | 0.25rem
 $dropdown-border-width                                | 1px
 $dropdown-box-shadow                                  | 0 0.5rem 1rem rgba(0, 0, 0, 0.175)
 $dropdown-color                                       | #212529
 $dropdown-divider-bg                                  | #e9ecef
 $dropdown-divider-margin-y                            | 0.5rem
 $dropdown-font-size                                   | 1rem
 $dropdown-header-color                                | #6c757d
 $dropdown-inner-border-radius                         | calc(0.25rem - 1px)
 $dropdown-item-padding-x                              | 1.5rem
 $dropdown-item-padding-y                              | 0.25rem
 $dropdown-link-active-bg                              | #007bff
 $dropdown-link-active-color                           | #fff
 $dropdown-link-color                                  | #212529
 $dropdown-link-disabled-color                         | #6c757d
 $dropdown-link-hover-bg                               | #f8f9fa
 $dropdown-link-hover-color                            | #16181b
 $dropdown-min-width                                   | 10rem
 $dropdown-padding-y                                   | 0.5rem
 $dropdown-spacer                                      | 0.125rem
 $dt-font-weight                                       | 700
 $embed-responsive-aspect-ratios                       | 21 9, 16 9, 4 3, 1 1
 $emphasized-link-hover-darken-percentage              | 0.15
 $enable-caret                                         | 1
 $enable-deprecation-messages                          | 1
 $enable-gradients                                     | 1
 $enable-grid-classes                                  | 1
 $enable-hover-media-query                             | 0
 $enable-pointer-cursor-for-buttons                    | 1
 $enable-prefers-reduced-motion-media-query            | 1
 $enable-print-styles                                  | 1
 $enable-responsive-font-sizes                         | 1
 $enable-rounded                                       | 1
 $enable-shadows                                       | 1
 $enable-transitions                                   | 1
 $enable-validation-icons                              | 1
 $error                                                | #dc3545
 $fa-border-color                                      | #eee
 $fa-css-prefix                                        | fa
 $fa-font-size-base                                    | 16px
 $fa-inverse                                           | #fff
 $fa-li-width                                          | 2em
 $fa-var-500px                                         | \f26e
 $fa-var-accessible-icon                               | \f368
 $fa-var-accusoft                                      | \f369
 $fa-var-address-book                                  | \f2b9
 $fa-var-address-card                                  | \f2bb
 $fa-var-adjust                                        | \f042
 $fa-var-adn                                           | \f170
 $fa-var-adversal                                      | \f36a
 $fa-var-affiliatetheme                                | \f36b
 $fa-var-algolia                                       | \f36c
 $fa-var-align-center                                  | \f037
 $fa-var-align-justify                                 | \f039
 $fa-var-align-left                                    | \f036
 $fa-var-align-right                                   | \f038
 $fa-var-allergies                                     | \f461
 $fa-var-amazon                                        | \f270
 $fa-var-amazon-pay                                    | \f42c
 $fa-var-ambulance                                     | \f0f9
 $fa-var-american-sign-language-interpreting           | \f2a3
 $fa-var-amilia                                        | \f36d
 $fa-var-anchor                                        | \f13d
 $fa-var-android                                       | \f17b
 $fa-var-angellist                                     | \f209
 $fa-var-angle-double-down                             | \f103
 $fa-var-angle-double-left                             | \f100
 $fa-var-angle-double-right                            | \f101
 $fa-var-angle-double-up                               | \f102
 $fa-var-angle-down                                    | \f107
 $fa-var-angle-left                                    | \f104
 $fa-var-angle-right                                   | \f105
 $fa-var-angle-up                                      | \f106
 $fa-var-angrycreative                                 | \f36e
 $fa-var-angular                                       | \f420
 $fa-var-app-store                                     | \f36f
 $fa-var-app-store-ios                                 | \f370
 $fa-var-apper                                         | \f371
 $fa-var-apple                                         | \f179
 $fa-var-apple-pay                                     | \f415
 $fa-var-archive                                       | \f187
 $fa-var-arrow-alt-circle-down                         | \f358
 $fa-var-arrow-alt-circle-left                         | \f359
 $fa-var-arrow-alt-circle-right                        | \f35a
 $fa-var-arrow-alt-circle-up                           | \f35b
 $fa-var-arrow-circle-down                             | \f0ab
 $fa-var-arrow-circle-left                             | \f0a8
 $fa-var-arrow-circle-right                            | \f0a9
 $fa-var-arrow-circle-up                               | \f0aa
 $fa-var-arrow-down                                    | \f063
 $fa-var-arrow-left                                    | \f060
 $fa-var-arrow-right                                   | \f061
 $fa-var-arrow-up                                      | \f062
 $fa-var-arrows-alt                                    | \f0b2
 $fa-var-arrows-alt-h                                  | \f337
 $fa-var-arrows-alt-v                                  | \f338
 $fa-var-assistive-listening-systems                   | \f2a2
 $fa-var-asterisk                                      | \f069
 $fa-var-asymmetrik                                    | \f372
 $fa-var-at                                            | \f1fa
 $fa-var-audible                                       | \f373
 $fa-var-audio-description                             | \f29e
 $fa-var-autoprefixer                                  | \f41c
 $fa-var-avianex                                       | \f374
 $fa-var-aviato                                        | \f421
 $fa-var-aws                                           | \f375
 $fa-var-backward                                      | \f04a
 $fa-var-balance-scale                                 | \f24e
 $fa-var-ban                                           | \f05e
 $fa-var-band-aid                                      | \f462
 $fa-var-bandcamp                                      | \f2d5
 $fa-var-barcode                                       | \f02a
 $fa-var-bars                                          | \f0c9
 $fa-var-baseball-ball                                 | \f433
 $fa-var-basketball-ball                               | \f434
 $fa-var-bath                                          | \f2cd
 $fa-var-battery-empty                                 | \f244
 $fa-var-battery-full                                  | \f240
 $fa-var-battery-half                                  | \f242
 $fa-var-battery-quarter                               | \f243
 $fa-var-battery-three-quarters                        | \f241
 $fa-var-bed                                           | \f236
 $fa-var-beer                                          | \f0fc
 $fa-var-behance                                       | \f1b4
 $fa-var-behance-square                                | \f1b5
 $fa-var-bell                                          | \f0f3
 $fa-var-bell-slash                                    | \f1f6
 $fa-var-bicycle                                       | \f206
 $fa-var-bimobject                                     | \f378
 $fa-var-binoculars                                    | \f1e5
 $fa-var-birthday-cake                                 | \f1fd
 $fa-var-bitbucket                                     | \f171
 $fa-var-bitcoin                                       | \f379
 $fa-var-bity                                          | \f37a
 $fa-var-black-tie                                     | \f27e
 $fa-var-blackberry                                    | \f37b
 $fa-var-blender                                       | \f517
 $fa-var-blind                                         | \f29d
 $fa-var-blogger                                       | \f37c
 $fa-var-blogger-b                                     | \f37d
 $fa-var-bluetooth                                     | \f293
 $fa-var-bluetooth-b                                   | \f294
 $fa-var-bold                                          | \f032
 $fa-var-bolt                                          | \f0e7
 $fa-var-bomb                                          | \f1e2
 $fa-var-book                                          | \f02d
 $fa-var-book-open                                     | \f518
 $fa-var-bookmark                                      | \f02e
 $fa-var-bowling-ball                                  | \f436
 $fa-var-box                                           | \f466
 $fa-var-box-open                                      | \f49e
 $fa-var-boxes                                         | \f468
 $fa-var-braille                                       | \f2a1
 $fa-var-briefcase                                     | \f0b1
 $fa-var-briefcase-medical                             | \f469
 $fa-var-broadcast-tower                               | \f519
 $fa-var-broom                                         | \f51a
 $fa-var-btc                                           | \f15a
 $fa-var-bug                                           | \f188
 $fa-var-building                                      | \f1ad
 $fa-var-bullhorn                                      | \f0a1
 $fa-var-bullseye                                      | \f140
 $fa-var-burn                                          | \f46a
 $fa-var-buromobelexperte                              | \f37f
 $fa-var-bus                                           | \f207
 $fa-var-buysellads                                    | \f20d
 $fa-var-calculator                                    | \f1ec
 $fa-var-calendar                                      | \f133
 $fa-var-calendar-alt                                  | \f073
 $fa-var-calendar-check                                | \f274
 $fa-var-calendar-minus                                | \f272
 $fa-var-calendar-plus                                 | \f271
 $fa-var-calendar-times                                | \f273
 $fa-var-camera                                        | \f030
 $fa-var-camera-retro                                  | \f083
 $fa-var-capsules                                      | \f46b
 $fa-var-car                                           | \f1b9
 $fa-var-caret-down                                    | \f0d7
 $fa-var-caret-left                                    | \f0d9
 $fa-var-caret-right                                   | \f0da
 $fa-var-caret-square-down                             | \f150
 $fa-var-caret-square-left                             | \f191
 $fa-var-caret-square-right                            | \f152
 $fa-var-caret-square-up                               | \f151
 $fa-var-caret-up                                      | \f0d8
 $fa-var-cart-arrow-down                               | \f218
 $fa-var-cart-plus                                     | \f217
 $fa-var-cc-amazon-pay                                 | \f42d
 $fa-var-cc-amex                                       | \f1f3
 $fa-var-cc-apple-pay                                  | \f416
 $fa-var-cc-diners-club                                | \f24c
 $fa-var-cc-discover                                   | \f1f2
 $fa-var-cc-jcb                                        | \f24b
 $fa-var-cc-mastercard                                 | \f1f1
 $fa-var-cc-paypal                                     | \f1f4
 $fa-var-cc-stripe                                     | \f1f5
 $fa-var-cc-visa                                       | \f1f0
 $fa-var-centercode                                    | \f380
 $fa-var-certificate                                   | \f0a3
 $fa-var-chalkboard                                    | \f51b
 $fa-var-chalkboard-teacher                            | \f51c
 $fa-var-chart-area                                    | \f1fe
 $fa-var-chart-bar                                     | \f080
 $fa-var-chart-line                                    | \f201
 $fa-var-chart-pie                                     | \f200
 $fa-var-check                                         | \f00c
 $fa-var-check-circle                                  | \f058
 $fa-var-check-square                                  | \f14a
 $fa-var-chess                                         | \f439
 $fa-var-chess-bishop                                  | \f43a
 $fa-var-chess-board                                   | \f43c
 $fa-var-chess-king                                    | \f43f
 $fa-var-chess-knight                                  | \f441
 $fa-var-chess-pawn                                    | \f443
 $fa-var-chess-queen                                   | \f445
 $fa-var-chess-rook                                    | \f447
 $fa-var-chevron-circle-down                           | \f13a
 $fa-var-chevron-circle-left                           | \f137
 $fa-var-chevron-circle-right                          | \f138
 $fa-var-chevron-circle-up                             | \f139
 $fa-var-chevron-down                                  | \f078
 $fa-var-chevron-left                                  | \f053
 $fa-var-chevron-right                                 | \f054
 $fa-var-chevron-up                                    | \f077
 $fa-var-child                                         | \f1ae
 $fa-var-chrome                                        | \f268
 $fa-var-church                                        | \f51d
 $fa-var-circle                                        | \f111
 $fa-var-circle-notch                                  | \f1ce
 $fa-var-clipboard                                     | \f328
 $fa-var-clipboard-check                               | \f46c
 $fa-var-clipboard-list                                | \f46d
 $fa-var-clock                                         | \f017
 $fa-var-clone                                         | \f24d
 $fa-var-closed-captioning                             | \f20a
 $fa-var-cloud                                         | \f0c2
 $fa-var-cloud-download-alt                            | \f381
 $fa-var-cloud-upload-alt                              | \f382
 $fa-var-cloudscale                                    | \f383
 $fa-var-cloudsmith                                    | \f384
 $fa-var-cloudversify                                  | \f385
 $fa-var-code                                          | \f121
 $fa-var-code-branch                                   | \f126
 $fa-var-codepen                                       | \f1cb
 $fa-var-codiepie                                      | \f284
 $fa-var-coffee                                        | \f0f4
 $fa-var-cog                                           | \f013
 $fa-var-cogs                                          | \f085
 $fa-var-coins                                         | \f51e
 $fa-var-columns                                       | \f0db
 $fa-var-comment                                       | \f075
 $fa-var-comment-alt                                   | \f27a
 $fa-var-comment-dots                                  | \f4ad
 $fa-var-comment-slash                                 | \f4b3
 $fa-var-comments                                      | \f086
 $fa-var-compact-disc                                  | \f51f
 $fa-var-compass                                       | \f14e
 $fa-var-compress                                      | \f066
 $fa-var-connectdevelop                                | \f20e
 $fa-var-contao                                        | \f26d
 $fa-var-copy                                          | \f0c5
 $fa-var-copyright                                     | \f1f9
 $fa-var-couch                                         | \f4b8
 $fa-var-cpanel                                        | \f388
 $fa-var-creative-commons                              | \f25e
 $fa-var-creative-commons-by                           | \f4e7
 $fa-var-creative-commons-nc                           | \f4e8
 $fa-var-creative-commons-nc-eu                        | \f4e9
 $fa-var-creative-commons-nc-jp                        | \f4ea
 $fa-var-creative-commons-nd                           | \f4eb
 $fa-var-creative-commons-pd                           | \f4ec
 $fa-var-creative-commons-pd-alt                       | \f4ed
 $fa-var-creative-commons-remix                        | \f4ee
 $fa-var-creative-commons-sa                           | \f4ef
 $fa-var-creative-commons-sampling                     | \f4f0
 $fa-var-creative-commons-sampling-plus                | \f4f1
 $fa-var-creative-commons-share                        | \f4f2
 $fa-var-credit-card                                   | \f09d
 $fa-var-crop                                          | \f125
 $fa-var-crosshairs                                    | \f05b
 $fa-var-crow                                          | \f520
 $fa-var-crown                                         | \f521
 $fa-var-css3                                          | \f13c
 $fa-var-css3-alt                                      | \f38b
 $fa-var-cube                                          | \f1b2
 $fa-var-cubes                                         | \f1b3
 $fa-var-cut                                           | \f0c4
 $fa-var-cuttlefish                                    | \f38c
 $fa-var-d-and-d                                       | \f38d
 $fa-var-dashcube                                      | \f210
 $fa-var-database                                      | \f1c0
 $fa-var-deaf                                          | \f2a4
 $fa-var-delicious                                     | \f1a5
 $fa-var-deploydog                                     | \f38e
 $fa-var-deskpro                                       | \f38f
 $fa-var-desktop                                       | \f108
 $fa-var-deviantart                                    | \f1bd
 $fa-var-diagnoses                                     | \f470
 $fa-var-dice                                          | \f522
 $fa-var-dice-five                                     | \f523
 $fa-var-dice-four                                     | \f524
 $fa-var-dice-one                                      | \f525
 $fa-var-dice-six                                      | \f526
 $fa-var-dice-three                                    | \f527
 $fa-var-dice-two                                      | \f528
 $fa-var-digg                                          | \f1a6
 $fa-var-digital-ocean                                 | \f391
 $fa-var-discord                                       | \f392
 $fa-var-discourse                                     | \f393
 $fa-var-divide                                        | \f529
 $fa-var-dna                                           | \f471
 $fa-var-dochub                                        | \f394
 $fa-var-docker                                        | \f395
 $fa-var-dollar-sign                                   | \f155
 $fa-var-dolly                                         | \f472
 $fa-var-dolly-flatbed                                 | \f474
 $fa-var-donate                                        | \f4b9
 $fa-var-door-closed                                   | \f52a
 $fa-var-door-open                                     | \f52b
 $fa-var-dot-circle                                    | \f192
 $fa-var-dove                                          | \f4ba
 $fa-var-download                                      | \f019
 $fa-var-draft2digital                                 | \f396
 $fa-var-dribbble                                      | \f17d
 $fa-var-dribbble-square                               | \f397
 $fa-var-dropbox                                       | \f16b
 $fa-var-drupal                                        | \f1a9
 $fa-var-dumbbell                                      | \f44b
 $fa-var-dyalog                                        | \f399
 $fa-var-earlybirds                                    | \f39a
 $fa-var-ebay                                          | \f4f4
 $fa-var-edge                                          | \f282
 $fa-var-edit                                          | \f044
 $fa-var-eject                                         | \f052
 $fa-var-elementor                                     | \f430
 $fa-var-ellipsis-h                                    | \f141
 $fa-var-ellipsis-v                                    | \f142
 $fa-var-ember                                         | \f423
 $fa-var-empire                                        | \f1d1
 $fa-var-envelope                                      | \f0e0
 $fa-var-envelope-open                                 | \f2b6
 $fa-var-envelope-square                               | \f199
 $fa-var-envira                                        | \f299
 $fa-var-equals                                        | \f52c
 $fa-var-eraser                                        | \f12d
 $fa-var-erlang                                        | \f39d
 $fa-var-ethereum                                      | \f42e
 $fa-var-etsy                                          | \f2d7
 $fa-var-euro-sign                                     | \f153
 $fa-var-exchange-alt                                  | \f362
 $fa-var-exclamation                                   | \f12a
 $fa-var-exclamation-circle                            | \f06a
 $fa-var-exclamation-triangle                          | \f071
 $fa-var-expand                                        | \f065
 $fa-var-expand-arrows-alt                             | \f31e
 $fa-var-expeditedssl                                  | \f23e
 $fa-var-external-link-alt                             | \f35d
 $fa-var-external-link-square-alt                      | \f360
 $fa-var-eye                                           | \f06e
 $fa-var-eye-dropper                                   | \f1fb
 $fa-var-eye-slash                                     | \f070
 $fa-var-facebook                                      | \f09a
 $fa-var-facebook-f                                    | \f39e
 $fa-var-facebook-messenger                            | \f39f
 $fa-var-facebook-square                               | \f082
 $fa-var-fast-backward                                 | \f049
 $fa-var-fast-forward                                  | \f050
 $fa-var-fax                                           | \f1ac
 $fa-var-feather                                       | \f52d
 $fa-var-female                                        | \f182
 $fa-var-fighter-jet                                   | \f0fb
 $fa-var-file                                          | \f15b
 $fa-var-file-alt                                      | \f15c
 $fa-var-file-archive                                  | \f1c6
 $fa-var-file-audio                                    | \f1c7
 $fa-var-file-code                                     | \f1c9
 $fa-var-file-excel                                    | \f1c3
 $fa-var-file-image                                    | \f1c5
 $fa-var-file-medical                                  | \f477
 $fa-var-file-medical-alt                              | \f478
 $fa-var-file-pdf                                      | \f1c1
 $fa-var-file-powerpoint                               | \f1c4
 $fa-var-file-video                                    | \f1c8
 $fa-var-file-word                                     | \f1c2
 $fa-var-film                                          | \f008
 $fa-var-filter                                        | \f0b0
 $fa-var-fire                                          | \f06d
 $fa-var-fire-extinguisher                             | \f134
 $fa-var-firefox                                       | \f269
 $fa-var-first-aid                                     | \f479
 $fa-var-first-order                                   | \f2b0
 $fa-var-first-order-alt                               | \f50a
 $fa-var-firstdraft                                    | \f3a1
 $fa-var-flag                                          | \f024
 $fa-var-flag-checkered                                | \f11e
 $fa-var-flask                                         | \f0c3
 $fa-var-flickr                                        | \f16e
 $fa-var-flipboard                                     | \f44d
 $fa-var-fly                                           | \f417
 $fa-var-folder                                        | \f07b
 $fa-var-folder-open                                   | \f07c
 $fa-var-font                                          | \f031
 $fa-var-font-awesome                                  | \f2b4
 $fa-var-font-awesome-alt                              | \f35c
 $fa-var-font-awesome-flag                             | \f425
 $fa-var-font-awesome-logo-full                        | \f4e6
 $fa-var-fonticons                                     | \f280
 $fa-var-fonticons-fi                                  | \f3a2
 $fa-var-football-ball                                 | \f44e
 $fa-var-fort-awesome                                  | \f286
 $fa-var-fort-awesome-alt                              | \f3a3
 $fa-var-forumbee                                      | \f211
 $fa-var-forward                                       | \f04e
 $fa-var-foursquare                                    | \f180
 $fa-var-free-code-camp                                | \f2c5
 $fa-var-freebsd                                       | \f3a4
 $fa-var-frog                                          | \f52e
 $fa-var-frown                                         | \f119
 $fa-var-fulcrum                                       | \f50b
 $fa-var-futbol                                        | \f1e3
 $fa-var-galactic-republic                             | \f50c
 $fa-var-galactic-senate                               | \f50d
 $fa-var-gamepad                                       | \f11b
 $fa-var-gas-pump                                      | \f52f
 $fa-var-gavel                                         | \f0e3
 $fa-var-gem                                           | \f3a5
 $fa-var-genderless                                    | \f22d
 $fa-var-get-pocket                                    | \f265
 $fa-var-gg                                            | \f260
 $fa-var-gg-circle                                     | \f261
 $fa-var-gift                                          | \f06b
 $fa-var-git                                           | \f1d3
 $fa-var-git-square                                    | \f1d2
 $fa-var-github                                        | \f09b
 $fa-var-github-alt                                    | \f113
 $fa-var-github-square                                 | \f092
 $fa-var-gitkraken                                     | \f3a6
 $fa-var-gitlab                                        | \f296
 $fa-var-gitter                                        | \f426
 $fa-var-glass-martini                                 | \f000
 $fa-var-glasses                                       | \f530
 $fa-var-glide                                         | \f2a5
 $fa-var-glide-g                                       | \f2a6
 $fa-var-globe                                         | \f0ac
 $fa-var-gofore                                        | \f3a7
 $fa-var-golf-ball                                     | \f450
 $fa-var-goodreads                                     | \f3a8
 $fa-var-goodreads-g                                   | \f3a9
 $fa-var-google                                        | \f1a0
 $fa-var-google-drive                                  | \f3aa
 $fa-var-google-play                                   | \f3ab
 $fa-var-google-plus                                   | \f2b3
 $fa-var-google-plus-g                                 | \f0d5
 $fa-var-google-plus-square                            | \f0d4
 $fa-var-google-wallet                                 | \f1ee
 $fa-var-graduation-cap                                | \f19d
 $fa-var-gratipay                                      | \f184
 $fa-var-grav                                          | \f2d6
 $fa-var-greater-than                                  | \f531
 $fa-var-greater-than-equal                            | \f532
 $fa-var-gripfire                                      | \f3ac
 $fa-var-grunt                                         | \f3ad
 $fa-var-gulp                                          | \f3ae
 $fa-var-h-square                                      | \f0fd
 $fa-var-hacker-news                                   | \f1d4
 $fa-var-hacker-news-square                            | \f3af
 $fa-var-hand-holding                                  | \f4bd
 $fa-var-hand-holding-heart                            | \f4be
 $fa-var-hand-holding-usd                              | \f4c0
 $fa-var-hand-lizard                                   | \f258
 $fa-var-hand-paper                                    | \f256
 $fa-var-hand-peace                                    | \f25b
 $fa-var-hand-point-down                               | \f0a7
 $fa-var-hand-point-left                               | \f0a5
 $fa-var-hand-point-right                              | \f0a4
 $fa-var-hand-point-up                                 | \f0a6
 $fa-var-hand-pointer                                  | \f25a
 $fa-var-hand-rock                                     | \f255
 $fa-var-hand-scissors                                 | \f257
 $fa-var-hand-spock                                    | \f259
 $fa-var-hands                                         | \f4c2
 $fa-var-hands-helping                                 | \f4c4
 $fa-var-handshake                                     | \f2b5
 $fa-var-hashtag                                       | \f292
 $fa-var-hdd                                           | \f0a0
 $fa-var-heading                                       | \f1dc
 $fa-var-headphones                                    | \f025
 $fa-var-heart                                         | \f004
 $fa-var-heartbeat                                     | \f21e
 $fa-var-helicopter                                    | \f533
 $fa-var-hips                                          | \f452
 $fa-var-hire-a-helper                                 | \f3b0
 $fa-var-history                                       | \f1da
 $fa-var-hockey-puck                                   | \f453
 $fa-var-home                                          | \f015
 $fa-var-hooli                                         | \f427
 $fa-var-hospital                                      | \f0f8
 $fa-var-hospital-alt                                  | \f47d
 $fa-var-hospital-symbol                               | \f47e
 $fa-var-hotjar                                        | \f3b1
 $fa-var-hourglass                                     | \f254
 $fa-var-hourglass-end                                 | \f253
 $fa-var-hourglass-half                                | \f252
 $fa-var-hourglass-start                               | \f251
 $fa-var-houzz                                         | \f27c
 $fa-var-html5                                         | \f13b
 $fa-var-hubspot                                       | \f3b2
 $fa-var-i-cursor                                      | \f246
 $fa-var-id-badge                                      | \f2c1
 $fa-var-id-card                                       | \f2c2
 $fa-var-id-card-alt                                   | \f47f
 $fa-var-image                                         | \f03e
 $fa-var-images                                        | \f302
 $fa-var-imdb                                          | \f2d8
 $fa-var-inbox                                         | \f01c
 $fa-var-indent                                        | \f03c
 $fa-var-industry                                      | \f275
 $fa-var-infinity                                      | \f534
 $fa-var-info                                          | \f129
 $fa-var-info-circle                                   | \f05a
 $fa-var-instagram                                     | \f16d
 $fa-var-internet-explorer                             | \f26b
 $fa-var-ioxhost                                       | \f208
 $fa-var-italic                                        | \f033
 $fa-var-itunes                                        | \f3b4
 $fa-var-itunes-note                                   | \f3b5
 $fa-var-java                                          | \f4e4
 $fa-var-jedi-order                                    | \f50e
 $fa-var-jenkins                                       | \f3b6
 $fa-var-joget                                         | \f3b7
 $fa-var-joomla                                        | \f1aa
 $fa-var-js                                            | \f3b8
 $fa-var-js-square                                     | \f3b9
 $fa-var-jsfiddle                                      | \f1cc
 $fa-var-key                                           | \f084
 $fa-var-keybase                                       | \f4f5
 $fa-var-keyboard                                      | \f11c
 $fa-var-keycdn                                        | \f3ba
 $fa-var-kickstarter                                   | \f3bb
 $fa-var-kickstarter-k                                 | \f3bc
 $fa-var-kiwi-bird                                     | \f535
 $fa-var-korvue                                        | \f42f
 $fa-var-language                                      | \f1ab
 $fa-var-laptop                                        | \f109
 $fa-var-laravel                                       | \f3bd
 $fa-var-lastfm                                        | \f202
 $fa-var-lastfm-square                                 | \f203
 $fa-var-leaf                                          | \f06c
 $fa-var-leanpub                                       | \f212
 $fa-var-lemon                                         | \f094
 $fa-var-less                                          | \f41d
 $fa-var-less-than                                     | \f536
 $fa-var-less-than-equal                               | \f537
 $fa-var-level-down-alt                                | \f3be
 $fa-var-level-up-alt                                  | \f3bf
 $fa-var-life-ring                                     | \f1cd
 $fa-var-lightbulb                                     | \f0eb
 $fa-var-line                                          | \f3c0
 $fa-var-link                                          | \f0c1
 $fa-var-linkedin                                      | \f08c
 $fa-var-linkedin-in                                   | \f0e1
 $fa-var-linode                                        | \f2b8
 $fa-var-linux                                         | \f17c
 $fa-var-lira-sign                                     | \f195
 $fa-var-list                                          | \f03a
 $fa-var-list-alt                                      | \f022
 $fa-var-list-ol                                       | \f0cb
 $fa-var-list-ul                                       | \f0ca
 $fa-var-location-arrow                                | \f124
 $fa-var-lock                                          | \f023
 $fa-var-lock-open                                     | \f3c1
 $fa-var-long-arrow-alt-down                           | \f309
 $fa-var-long-arrow-alt-left                           | \f30a
 $fa-var-long-arrow-alt-right                          | \f30b
 $fa-var-long-arrow-alt-up                             | \f30c
 $fa-var-low-vision                                    | \f2a8
 $fa-var-lyft                                          | \f3c3
 $fa-var-magento                                       | \f3c4
 $fa-var-magic                                         | \f0d0
 $fa-var-magnet                                        | \f076
 $fa-var-male                                          | \f183
 $fa-var-mandalorian                                   | \f50f
 $fa-var-map                                           | \f279
 $fa-var-map-marker                                    | \f041
 $fa-var-map-marker-alt                                | \f3c5
 $fa-var-map-pin                                       | \f276
 $fa-var-map-signs                                     | \f277
 $fa-var-mars                                          | \f222
 $fa-var-mars-double                                   | \f227
 $fa-var-mars-stroke                                   | \f229
 $fa-var-mars-stroke-h                                 | \f22b
 $fa-var-mars-stroke-v                                 | \f22a
 $fa-var-mastodon                                      | \f4f6
 $fa-var-maxcdn                                        | \f136
 $fa-var-medapps                                       | \f3c6
 $fa-var-medium                                        | \f23a
 $fa-var-medium-m                                      | \f3c7
 $fa-var-medkit                                        | \f0fa
 $fa-var-medrt                                         | \f3c8
 $fa-var-meetup                                        | \f2e0
 $fa-var-meh                                           | \f11a
 $fa-var-memory                                        | \f538
 $fa-var-mercury                                       | \f223
 $fa-var-microchip                                     | \f2db
 $fa-var-microphone                                    | \f130
 $fa-var-microphone-alt                                | \f3c9
 $fa-var-microphone-alt-slash                          | \f539
 $fa-var-microphone-slash                              | \f131
 $fa-var-microsoft                                     | \f3ca
 $fa-var-minus                                         | \f068
 $fa-var-minus-circle                                  | \f056
 $fa-var-minus-square                                  | \f146
 $fa-var-mix                                           | \f3cb
 $fa-var-mixcloud                                      | \f289
 $fa-var-mizuni                                        | \f3cc
 $fa-var-mobile                                        | \f10b
 $fa-var-mobile-alt                                    | \f3cd
 $fa-var-modx                                          | \f285
 $fa-var-monero                                        | \f3d0
 $fa-var-money-bill                                    | \f0d6
 $fa-var-money-bill-alt                                | \f3d1
 $fa-var-money-bill-wave                               | \f53a
 $fa-var-money-bill-wave-alt                           | \f53b
 $fa-var-money-check                                   | \f53c
 $fa-var-money-check-alt                               | \f53d
 $fa-var-moon                                          | \f186
 $fa-var-motorcycle                                    | \f21c
 $fa-var-mouse-pointer                                 | \f245
 $fa-var-music                                         | \f001
 $fa-var-napster                                       | \f3d2
 $fa-var-neuter                                        | \f22c
 $fa-var-newspaper                                     | \f1ea
 $fa-var-nintendo-switch                               | \f418
 $fa-var-node                                          | \f419
 $fa-var-node-js                                       | \f3d3
 $fa-var-not-equal                                     | \f53e
 $fa-var-notes-medical                                 | \f481
 $fa-var-npm                                           | \f3d4
 $fa-var-ns8                                           | \f3d5
 $fa-var-nutritionix                                   | \f3d6
 $fa-var-object-group                                  | \f247
 $fa-var-object-ungroup                                | \f248
 $fa-var-odnoklassniki                                 | \f263
 $fa-var-odnoklassniki-square                          | \f264
 $fa-var-old-republic                                  | \f510
 $fa-var-opencart                                      | \f23d
 $fa-var-openid                                        | \f19b
 $fa-var-opera                                         | \f26a
 $fa-var-optin-monster                                 | \f23c
 $fa-var-osi                                           | \f41a
 $fa-var-outdent                                       | \f03b
 $fa-var-page4                                         | \f3d7
 $fa-var-pagelines                                     | \f18c
 $fa-var-paint-brush                                   | \f1fc
 $fa-var-palette                                       | \f53f
 $fa-var-palfed                                        | \f3d8
 $fa-var-pallet                                        | \f482
 $fa-var-paper-plane                                   | \f1d8
 $fa-var-paperclip                                     | \f0c6
 $fa-var-parachute-box                                 | \f4cd
 $fa-var-paragraph                                     | \f1dd
 $fa-var-parking                                       | \f540
 $fa-var-paste                                         | \f0ea
 $fa-var-patreon                                       | \f3d9
 $fa-var-pause                                         | \f04c
 $fa-var-pause-circle                                  | \f28b
 $fa-var-paw                                           | \f1b0
 $fa-var-paypal                                        | \f1ed
 $fa-var-pen-square                                    | \f14b
 $fa-var-pencil-alt                                    | \f303
 $fa-var-people-carry                                  | \f4ce
 $fa-var-percent                                       | \f295
 $fa-var-percentage                                    | \f541
 $fa-var-periscope                                     | \f3da
 $fa-var-phabricator                                   | \f3db
 $fa-var-phoenix-framework                             | \f3dc
 $fa-var-phoenix-squadron                              | \f511
 $fa-var-phone                                         | \f095
 $fa-var-phone-slash                                   | \f3dd
 $fa-var-phone-square                                  | \f098
 $fa-var-phone-volume                                  | \f2a0
 $fa-var-php                                           | \f457
 $fa-var-pied-piper                                    | \f2ae
 $fa-var-pied-piper-alt                                | \f1a8
 $fa-var-pied-piper-hat                                | \f4e5
 $fa-var-pied-piper-pp                                 | \f1a7
 $fa-var-piggy-bank                                    | \f4d3
 $fa-var-pills                                         | \f484
 $fa-var-pinterest                                     | \f0d2
 $fa-var-pinterest-p                                   | \f231
 $fa-var-pinterest-square                              | \f0d3
 $fa-var-plane                                         | \f072
 $fa-var-play                                          | \f04b
 $fa-var-play-circle                                   | \f144
 $fa-var-playstation                                   | \f3df
 $fa-var-plug                                          | \f1e6
 $fa-var-plus                                          | \f067
 $fa-var-plus-circle                                   | \f055
 $fa-var-plus-square                                   | \f0fe
 $fa-var-podcast                                       | \f2ce
 $fa-var-poo                                           | \f2fe
 $fa-var-portrait                                      | \f3e0
 $fa-var-pound-sign                                    | \f154
 $fa-var-power-off                                     | \f011
 $fa-var-prescription-bottle                           | \f485
 $fa-var-prescription-bottle-alt                       | \f486
 $fa-var-print                                         | \f02f
 $fa-var-procedures                                    | \f487
 $fa-var-product-hunt                                  | \f288
 $fa-var-project-diagram                               | \f542
 $fa-var-pushed                                        | \f3e1
 $fa-var-puzzle-piece                                  | \f12e
 $fa-var-python                                        | \f3e2
 $fa-var-qq                                            | \f1d6
 $fa-var-qrcode                                        | \f029
 $fa-var-question                                      | \f128
 $fa-var-question-circle                               | \f059
 $fa-var-quidditch                                     | \f458
 $fa-var-quinscape                                     | \f459
 $fa-var-quora                                         | \f2c4
 $fa-var-quote-left                                    | \f10d
 $fa-var-quote-right                                   | \f10e
 $fa-var-r-project                                     | \f4f7
 $fa-var-random                                        | \f074
 $fa-var-ravelry                                       | \f2d9
 $fa-var-react                                         | \f41b
 $fa-var-readme                                        | \f4d5
 $fa-var-rebel                                         | \f1d0
 $fa-var-receipt                                       | \f543
 $fa-var-recycle                                       | \f1b8
 $fa-var-red-river                                     | \f3e3
 $fa-var-reddit                                        | \f1a1
 $fa-var-reddit-alien                                  | \f281
 $fa-var-reddit-square                                 | \f1a2
 $fa-var-redo                                          | \f01e
 $fa-var-redo-alt                                      | \f2f9
 $fa-var-registered                                    | \f25d
 $fa-var-rendact                                       | \f3e4
 $fa-var-renren                                        | \f18b
 $fa-var-reply                                         | \f3e5
 $fa-var-reply-all                                     | \f122
 $fa-var-replyd                                        | \f3e6
 $fa-var-researchgate                                  | \f4f8
 $fa-var-resolving                                     | \f3e7
 $fa-var-retweet                                       | \f079
 $fa-var-ribbon                                        | \f4d6
 $fa-var-road                                          | \f018
 $fa-var-robot                                         | \f544
 $fa-var-rocket                                        | \f135
 $fa-var-rocketchat                                    | \f3e8
 $fa-var-rockrms                                       | \f3e9
 $fa-var-rss                                           | \f09e
 $fa-var-rss-square                                    | \f143
 $fa-var-ruble-sign                                    | \f158
 $fa-var-ruler                                         | \f545
 $fa-var-ruler-combined                                | \f546
 $fa-var-ruler-horizontal                              | \f547
 $fa-var-ruler-vertical                                | \f548
 $fa-var-rupee-sign                                    | \f156
 $fa-var-safari                                        | \f267
 $fa-var-sass                                          | \f41e
 $fa-var-save                                          | \f0c7
 $fa-var-schlix                                        | \f3ea
 $fa-var-school                                        | \f549
 $fa-var-screwdriver                                   | \f54a
 $fa-var-scribd                                        | \f28a
 $fa-var-search                                        | \f002
 $fa-var-search-minus                                  | \f010
 $fa-var-search-plus                                   | \f00e
 $fa-var-searchengin                                   | \f3eb
 $fa-var-seedling                                      | \f4d8
 $fa-var-sellcast                                      | \f2da
 $fa-var-sellsy                                        | \f213
 $fa-var-server                                        | \f233
 $fa-var-servicestack                                  | \f3ec
 $fa-var-share                                         | \f064
 $fa-var-share-alt                                     | \f1e0
 $fa-var-share-alt-square                              | \f1e1
 $fa-var-share-square                                  | \f14d
 $fa-var-shekel-sign                                   | \f20b
 $fa-var-shield-alt                                    | \f3ed
 $fa-var-ship                                          | \f21a
 $fa-var-shipping-fast                                 | \f48b
 $fa-var-shirtsinbulk                                  | \f214
 $fa-var-shoe-prints                                   | \f54b
 $fa-var-shopping-bag                                  | \f290
 $fa-var-shopping-basket                               | \f291
 $fa-var-shopping-cart                                 | \f07a
 $fa-var-shower                                        | \f2cc
 $fa-var-sign                                          | \f4d9
 $fa-var-sign-in-alt                                   | \f2f6
 $fa-var-sign-language                                 | \f2a7
 $fa-var-sign-out-alt                                  | \f2f5
 $fa-var-signal                                        | \f012
 $fa-var-simplybuilt                                   | \f215
 $fa-var-sistrix                                       | \f3ee
 $fa-var-sitemap                                       | \f0e8
 $fa-var-sith                                          | \f512
 $fa-var-skull                                         | \f54c
 $fa-var-skyatlas                                      | \f216
 $fa-var-skype                                         | \f17e
 $fa-var-slack                                         | \f198
 $fa-var-slack-hash                                    | \f3ef
 $fa-var-sliders-h                                     | \f1de
 $fa-var-slideshare                                    | \f1e7
 $fa-var-smile                                         | \f118
 $fa-var-smoking                                       | \f48d
 $fa-var-smoking-ban                                   | \f54d
 $fa-var-snapchat                                      | \f2ab
 $fa-var-snapchat-ghost                                | \f2ac
 $fa-var-snapchat-square                               | \f2ad
 $fa-var-snowflake                                     | \f2dc
 $fa-var-sort                                          | \f0dc
 $fa-var-sort-alpha-down                               | \f15d
 $fa-var-sort-alpha-up                                 | \f15e
 $fa-var-sort-amount-down                              | \f160
 $fa-var-sort-amount-up                                | \f161
 $fa-var-sort-down                                     | \f0dd
 $fa-var-sort-numeric-down                             | \f162
 $fa-var-sort-numeric-up                               | \f163
 $fa-var-sort-up                                       | \f0de
 $fa-var-soundcloud                                    | \f1be
 $fa-var-space-shuttle                                 | \f197
 $fa-var-speakap                                       | \f3f3
 $fa-var-spinner                                       | \f110
 $fa-var-spotify                                       | \f1bc
 $fa-var-square                                        | \f0c8
 $fa-var-square-full                                   | \f45c
 $fa-var-stack-exchange                                | \f18d
 $fa-var-stack-overflow                                | \f16c
 $fa-var-star                                          | \f005
 $fa-var-star-half                                     | \f089
 $fa-var-staylinked                                    | \f3f5
 $fa-var-steam                                         | \f1b6
 $fa-var-steam-square                                  | \f1b7
 $fa-var-steam-symbol                                  | \f3f6
 $fa-var-step-backward                                 | \f048
 $fa-var-step-forward                                  | \f051
 $fa-var-stethoscope                                   | \f0f1
 $fa-var-sticker-mule                                  | \f3f7
 $fa-var-sticky-note                                   | \f249
 $fa-var-stop                                          | \f04d
 $fa-var-stop-circle                                   | \f28d
 $fa-var-stopwatch                                     | \f2f2
 $fa-var-store                                         | \f54e
 $fa-var-store-alt                                     | \f54f
 $fa-var-strava                                        | \f428
 $fa-var-stream                                        | \f550
 $fa-var-street-view                                   | \f21d
 $fa-var-strikethrough                                 | \f0cc
 $fa-var-stripe                                        | \f429
 $fa-var-stripe-s                                      | \f42a
 $fa-var-stroopwafel                                   | \f551
 $fa-var-studiovinari                                  | \f3f8
 $fa-var-stumbleupon                                   | \f1a4
 $fa-var-stumbleupon-circle                            | \f1a3
 $fa-var-subscript                                     | \f12c
 $fa-var-subway                                        | \f239
 $fa-var-suitcase                                      | \f0f2
 $fa-var-sun                                           | \f185
 $fa-var-superpowers                                   | \f2dd
 $fa-var-superscript                                   | \f12b
 $fa-var-supple                                        | \f3f9
 $fa-var-sync                                          | \f021
 $fa-var-sync-alt                                      | \f2f1
 $fa-var-syringe                                       | \f48e
 $fa-var-table                                         | \f0ce
 $fa-var-table-tennis                                  | \f45d
 $fa-var-tablet                                        | \f10a
 $fa-var-tablet-alt                                    | \f3fa
 $fa-var-tablets                                       | \f490
 $fa-var-tachometer-alt                                | \f3fd
 $fa-var-tag                                           | \f02b
 $fa-var-tags                                          | \f02c
 $fa-var-tape                                          | \f4db
 $fa-var-tasks                                         | \f0ae
 $fa-var-taxi                                          | \f1ba
 $fa-var-teamspeak                                     | \f4f9
 $fa-var-telegram                                      | \f2c6
 $fa-var-telegram-plane                                | \f3fe
 $fa-var-tencent-weibo                                 | \f1d5
 $fa-var-terminal                                      | \f120
 $fa-var-text-height                                   | \f034
 $fa-var-text-width                                    | \f035
 $fa-var-th                                            | \f00a
 $fa-var-th-large                                      | \f009
 $fa-var-th-list                                       | \f00b
 $fa-var-themeisle                                     | \f2b2
 $fa-var-thermometer                                   | \f491
 $fa-var-thermometer-empty                             | \f2cb
 $fa-var-thermometer-full                              | \f2c7
 $fa-var-thermometer-half                              | \f2c9
 $fa-var-thermometer-quarter                           | \f2ca
 $fa-var-thermometer-three-quarters                    | \f2c8
 $fa-var-thumbs-down                                   | \f165
 $fa-var-thumbs-up                                     | \f164
 $fa-var-thumbtack                                     | \f08d
 $fa-var-ticket-alt                                    | \f3ff
 $fa-var-times                                         | \f00d
 $fa-var-times-circle                                  | \f057
 $fa-var-tint                                          | \f043
 $fa-var-toggle-off                                    | \f204
 $fa-var-toggle-on                                     | \f205
 $fa-var-toolbox                                       | \f552
 $fa-var-trade-federation                              | \f513
 $fa-var-trademark                                     | \f25c
 $fa-var-train                                         | \f238
 $fa-var-transgender                                   | \f224
 $fa-var-transgender-alt                               | \f225
 $fa-var-trash                                         | \f1f8
 $fa-var-trash-alt                                     | \f2ed
 $fa-var-tree                                          | \f1bb
 $fa-var-trello                                        | \f181
 $fa-var-tripadvisor                                   | \f262
 $fa-var-trophy                                        | \f091
 $fa-var-truck                                         | \f0d1
 $fa-var-truck-loading                                 | \f4de
 $fa-var-truck-moving                                  | \f4df
 $fa-var-tshirt                                        | \f553
 $fa-var-tty                                           | \f1e4
 $fa-var-tumblr                                        | \f173
 $fa-var-tumblr-square                                 | \f174
 $fa-var-tv                                            | \f26c
 $fa-var-twitch                                        | \f1e8
 $fa-var-twitter                                       | \f099
 $fa-var-twitter-square                                | \f081
 $fa-var-typo3                                         | \f42b
 $fa-var-uber                                          | \f402
 $fa-var-uikit                                         | \f403
 $fa-var-umbrella                                      | \f0e9
 $fa-var-underline                                     | \f0cd
 $fa-var-undo                                          | \f0e2
 $fa-var-undo-alt                                      | \f2ea
 $fa-var-uniregistry                                   | \f404
 $fa-var-universal-access                              | \f29a
 $fa-var-university                                    | \f19c
 $fa-var-unlink                                        | \f127
 $fa-var-unlock                                        | \f09c
 $fa-var-unlock-alt                                    | \f13e
 $fa-var-untappd                                       | \f405
 $fa-var-upload                                        | \f093
 $fa-var-usb                                           | \f287
 $fa-var-user                                          | \f007
 $fa-var-user-alt                                      | \f406
 $fa-var-user-alt-slash                                | \f4fa
 $fa-var-user-astronaut                                | \f4fb
 $fa-var-user-check                                    | \f4fc
 $fa-var-user-circle                                   | \f2bd
 $fa-var-user-clock                                    | \f4fd
 $fa-var-user-cog                                      | \f4fe
 $fa-var-user-edit                                     | \f4ff
 $fa-var-user-friends                                  | \f500
 $fa-var-user-graduate                                 | \f501
 $fa-var-user-lock                                     | \f502
 $fa-var-user-md                                       | \f0f0
 $fa-var-user-minus                                    | \f503
 $fa-var-user-ninja                                    | \f504
 $fa-var-user-plus                                     | \f234
 $fa-var-user-secret                                   | \f21b
 $fa-var-user-shield                                   | \f505
 $fa-var-user-slash                                    | \f506
 $fa-var-user-tag                                      | \f507
 $fa-var-user-tie                                      | \f508
 $fa-var-user-times                                    | \f235
 $fa-var-users                                         | \f0c0
 $fa-var-users-cog                                     | \f509
 $fa-var-ussunnah                                      | \f407
 $fa-var-utensil-spoon                                 | \f2e5
 $fa-var-utensils                                      | \f2e7
 $fa-var-vaadin                                        | \f408
 $fa-var-venus                                         | \f221
 $fa-var-venus-double                                  | \f226
 $fa-var-venus-mars                                    | \f228
 $fa-var-viacoin                                       | \f237
 $fa-var-viadeo                                        | \f2a9
 $fa-var-viadeo-square                                 | \f2aa
 $fa-var-vial                                          | \f492
 $fa-var-vials                                         | \f493
 $fa-var-viber                                         | \f409
 $fa-var-video                                         | \f03d
 $fa-var-video-slash                                   | \f4e2
 $fa-var-vimeo                                         | \f40a
 $fa-var-vimeo-square                                  | \f194
 $fa-var-vimeo-v                                       | \f27d
 $fa-var-vine                                          | \f1ca
 $fa-var-vk                                            | \f189
 $fa-var-vnv                                           | \f40b
 $fa-var-volleyball-ball                               | \f45f
 $fa-var-volume-down                                   | \f027
 $fa-var-volume-off                                    | \f026
 $fa-var-volume-up                                     | \f028
 $fa-var-vuejs                                         | \f41f
 $fa-var-walking                                       | \f554
 $fa-var-wallet                                        | \f555
 $fa-var-warehouse                                     | \f494
 $fa-var-weibo                                         | \f18a
 $fa-var-weight                                        | \f496
 $fa-var-weixin                                        | \f1d7
 $fa-var-whatsapp                                      | \f232
 $fa-var-whatsapp-square                               | \f40c
 $fa-var-wheelchair                                    | \f193
 $fa-var-whmcs                                         | \f40d
 $fa-var-wifi                                          | \f1eb
 $fa-var-wikipedia-w                                   | \f266
 $fa-var-window-close                                  | \f410
 $fa-var-window-maximize                               | \f2d0
 $fa-var-window-minimize                               | \f2d1
 $fa-var-window-restore                                | \f2d2
 $fa-var-windows                                       | \f17a
 $fa-var-wine-glass                                    | \f4e3
 $fa-var-wolf-pack-battalion                           | \f514
 $fa-var-won-sign                                      | \f159
 $fa-var-wordpress                                     | \f19a
 $fa-var-wordpress-simple                              | \f411
 $fa-var-wpbeginner                                    | \f297
 $fa-var-wpexplorer                                    | \f2de
 $fa-var-wpforms                                       | \f298
 $fa-var-wrench                                        | \f0ad
 $fa-var-x-ray                                         | \f497
 $fa-var-xbox                                          | \f412
 $fa-var-xing                                          | \f168
 $fa-var-xing-square                                   | \f169
 $fa-var-y-combinator                                  | \f23b
 $fa-var-yahoo                                         | \f19e
 $fa-var-yandex                                        | \f413
 $fa-var-yandex-international                          | \f414
 $fa-var-yelp                                          | \f1e9
 $fa-var-yen-sign                                      | \f157
 $fa-var-yoast                                         | \f2b1
 $fa-var-youtube                                       | \f167
 $fa-var-youtube-square                                | \f431
 $fa-version                                           | 5.0.13
 $figure-caption-color                                 | #6c757d
 $figure-caption-font-size                             | 0.9
 $font-family-base                                     | -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"
 $font-family-monospace                                | SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace
 $font-family-sans-serif                               | -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"
 $font-size-base                                       | 1rem
 $font-size-lg                                         | 1.25rem
 $font-size-sm                                         | 0.875rem
 $font-weight-base                                     | 400
 $font-weight-bold                                     | 700
 $font-weight-bolder                                   | bolder
 $font-weight-light                                    | 300
 $font-weight-lighter                                  | lighter
 $font-weight-normal                                   | 400
 $form-check-inline-input-margin-x                     | 0.3125rem
 $form-check-inline-margin-x                           | 0.75rem
 $form-check-input-gutter                              | 1.25rem
 $form-check-input-margin-x                            | 0.25rem
 $form-check-input-margin-y                            | 0.3rem
 $form-feedback-font-size                              | 0.8
 $form-feedback-icon-invalid                           | url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23dc3545' viewBox='-2 -2 7 7'%3e%3cpath stroke='%23dc3545' d='M0 0l3 3m0-3L0 3'/%3e%3ccircle r='.5'/%3e%3ccircle cx='3' r='.5'/%3e%3ccircle cy='3' r='.5'/%3e%3ccircle cx='3' cy='3' r='.5'/%3e%3c/svg%3E")
 $form-feedback-icon-invalid-color                     | #dc3545
 $form-feedback-icon-valid                             | url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e")
 $form-feedback-icon-valid-color                       | #28a745
 $form-feedback-invalid-color                          | #dc3545
 $form-feedback-margin-top                             | 0.25rem
 $form-feedback-tooltip-border-radius                  | 0.25rem
 $form-feedback-tooltip-font-size                      | 0.875rem
 $form-feedback-tooltip-line-height                    | 1.5
 $form-feedback-tooltip-opacity                        | 0.9
 $form-feedback-tooltip-padding-x                      | 0.5rem
 $form-feedback-tooltip-padding-y                      | 0.25rem
 $form-feedback-valid-color                            | #28a745
 $form-grid-gutter-width                               | 10px
 $form-group-margin-bottom                             | 1rem
 $form-text-margin-top                                 | 0.25rem
 $form-validation-states                               | ("valid": ("color": #28a745, "icon": url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e")), "invalid": ("color": #dc3545, "icon": url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23dc3545' viewBox='-2 -2 7 7'%3e%3cpath stroke='%23dc3545' d='M0 0l3 3m0-3L0 3'/%3e%3ccircle r='.5'/%3e%3ccircle cx='3' r='.5'/%3e%3ccircle cy='3' r='.5'/%3e%3ccircle cx='3' cy='3' r='.5'/%3e%3c/svg%3E")))
 $gray-100                                             | #f8f9fa
 $gray-200                                             | #e9ecef
 $gray-300                                             | #dee2e6
 $gray-400                                             | #ced4da
 $gray-500                                             | #adb5bd
 $gray-600                                             | #6c757d
 $gray-700                                             | #495057
 $gray-800                                             | #343a40
 $gray-900                                             | #212529
 $grays                                                | ("100": #f8f9fa, "200": #e9ecef, "300": #dee2e6, "400": #ced4da, "500": #adb5bd, "600": #6c757d, "700": #495057, "800": #343a40, "900": #212529)
 $green                                                | #28a745
 $grid-columns                                         | 12
 $grid-gutter-width                                    | 30px
 $h1-font-size                                         | 2.2rem
 $h2-font-size                                         | 1.7rem
 $h3-font-size                                         | 1.4rem
 $h4-font-size                                         | 1.2rem
 $h5-font-size                                         | 1.1rem
 $h6-font-size                                         | 1rem
 $headings-color                                       | null
 $headings-font-family                                 | null
 $headings-font-weight                                 | 500
 $headings-line-height                                 | 1.2
 $headings-margin-bottom                               | 0.5rem
 $hr-border-color                                      | rgba(0, 0, 0, 0.1)
 $hr-border-width                                      | 1px
 $hr-margin-y                                          | 1rem
 $indigo                                               | #6610f2
 $info                                                 | #17a2b8
 $input-bg                                             | #fff
 $input-border-color                                   | #ced4da
 $input-border-radius                                  | 0.25rem
 $input-border-radius-lg                               | 0.3rem
 $input-border-radius-sm                               | 0.2rem
 $input-border-width                                   | 1px
 $input-box-shadow                                     | inset 0 1px 1px rgba(0, 0, 0, 0.075)
 $input-btn-border-width                               | 1px
 $input-btn-focus-box-shadow                           | 0 0 0 0.2rem rgba(0, 123, 255, 0.25)
 $input-btn-focus-color                                | rgba(0, 123, 255, 0.25)
 $input-btn-focus-width                                | 0.2rem
 $input-btn-font-family                                | null
 $input-btn-font-size                                  | 1rem
 $input-btn-font-size-lg                               | 1.25rem
 $input-btn-font-size-sm                               | 0.875rem
 $input-btn-line-height                                | 1.5
 $input-btn-line-height-lg                             | 1.5
 $input-btn-line-height-sm                             | 1.5
 $input-btn-padding-x                                  | 0.75rem
 $input-btn-padding-x-lg                               | 1rem
 $input-btn-padding-x-sm                               | 0.5rem
 $input-btn-padding-y                                  | 0.375rem
 $input-btn-padding-y-lg                               | 0.5rem
 $input-btn-padding-y-sm                               | 0.25rem
 $input-color                                          | #495057
 $input-disabled-bg                                    | #e9ecef
 $input-focus-bg                                       | #fff
 $input-focus-border-color                             | #80bdff
 $input-focus-box-shadow                               | 0 0 0 0.2rem rgba(0, 123, 255, 0.25)
 $input-focus-color                                    | #495057
 $input-focus-width                                    | 0.2rem
 $input-font-family                                    | null
 $input-font-size                                      | 1rem
 $input-font-size-lg                                   | 1.25rem
 $input-font-size-sm                                   | 0.875rem
 $input-font-weight                                    | 400
 $input-group-addon-bg                                 | #e9ecef
 $input-group-addon-border-color                       | #ced4da
 $input-group-addon-color                              | #495057
 $input-height                                         | calc(1.5em + 0.75rem + 2px)
 $input-height-border                                  | 2px
 $input-height-inner                                   | calc(1.5em + 0.75rem)
 $input-height-inner-half                              | calc(0.75em + 0.375rem)
 $input-height-inner-quarter                           | calc(0.375em + 0.1875rem)
 $input-height-lg                                      | calc(1.5em + 1rem + 2px)
 $input-height-sm                                      | calc(1.5em + 0.5rem + 2px)
 $input-line-height                                    | 1.5
 $input-line-height-lg                                 | 1.5
 $input-line-height-sm                                 | 1.5
 $input-padding-x                                      | 0.75rem
 $input-padding-x-lg                                   | 1rem
 $input-padding-x-sm                                   | 0.5rem
 $input-padding-y                                      | 0.375rem
 $input-padding-y-lg                                   | 0.5rem
 $input-padding-y-sm                                   | 0.25rem
 $input-placeholder-color                              | #6c757d
 $input-plaintext-color                                | #212529
 $input-transition                                     | border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out
 $jumbotron-bg                                         | #e9ecef
 $jumbotron-color                                      | null
 $jumbotron-padding                                    | 2rem
 $kbd-bg                                               | #212529
 $kbd-box-shadow                                       | inset 0 -0.1rem 0 rgba(0, 0, 0, 0.25)
 $kbd-color                                            | #fff
 $kbd-font-size                                        | 0.875
 $kbd-padding-x                                        | 0.4rem
 $kbd-padding-y                                        | 0.2rem
 $label-margin-bottom                                  | 0.5rem
 $lead-font-size                                       | 1.25rem
 $lead-font-weight                                     | 300
 $light                                                | #e9ecef
 $line-height-base                                     | 1.5
 $line-height-lg                                       | 1.5
 $line-height-sm                                       | 1.5
 $link-color                                           | #1b599b
 $link-decoration                                      | none
 $link-hover-color                                     | #10345a
 $link-hover-decoration                                | underline
 $list-bullet-color                                    | #dee2e6
 $list-bullet-size                                     | 0.5rem
 $list-group-action-active-bg                          | #e9ecef
 $list-group-action-active-color                       | #212529
 $list-group-action-color                              | #495057
 $list-group-action-hover-color                        | #495057
 $list-group-active-bg                                 | #007bff
 $list-group-active-border-color                       | #007bff
 $list-group-active-color                              | #fff
 $list-group-bg                                        | #fff
 $list-group-border-color                              | rgba(0, 0, 0, 0.125)
 $list-group-border-radius                             | 0.25rem
 $list-group-border-width                              | 1px
 $list-group-color                                     | null
 $list-group-disabled-bg                               | #fff
 $list-group-disabled-color                            | #6c757d
 $list-group-hover-bg                                  | #f8f9fa
 $list-group-item-padding-x                            | 1.25rem
 $list-group-item-padding-y                            | 0.75rem
 $list-inline-padding                                  | 0.5rem
 $list-level-indent                                    | 3.5ex
 $mark-bg                                              | #fcf8e3
 $mark-padding                                         | 0.2em
 $modal-backdrop-bg                                    | #000
 $modal-backdrop-opacity                               | 0.5
 $modal-content-bg                                     | #fff
 $modal-content-border-color                           | rgba(0, 0, 0, 0.2)
 $modal-content-border-radius                          | 0.3rem
 $modal-content-border-width                           | 1px
 $modal-content-box-shadow-sm-up                       | 0 0.5rem 1rem rgba(0, 0, 0, 0.5)
 $modal-content-box-shadow-xs                          | 0 0.25rem 0.5rem rgba(0, 0, 0, 0.5)
 $modal-content-color                                  | null
 $modal-dialog-margin                                  | 0.5rem
 $modal-dialog-margin-y-sm-up                          | 1.75rem
 $modal-fade-transform                                 | translate(0, -50px)
 $modal-footer-border-color                            | #dee2e6
 $modal-footer-border-width                            | 1px
 $modal-header-border-color                            | #dee2e6
 $modal-header-border-width                            | 1px
 $modal-header-padding                                 | 1rem 1rem
 $modal-header-padding-x                               | 1rem
 $modal-header-padding-y                               | 1rem
 $modal-inner-padding                                  | 1rem
 $modal-lg                                             | 800px
 $modal-md                                             | 500px
 $modal-show-transform                                 | none
 $modal-sm                                             | 300px
 $modal-title-line-height                              | 1.5
 $modal-transition                                     | transform 0.3s ease-out
 $modal-xl                                             | 1140px
 $nav-divider-color                                    | #e9ecef
 $nav-divider-margin-y                                 | 0.5rem
 $nav-link-disabled-color                              | #6c757d
 $nav-link-height                                      | 2.5rem
 $nav-link-padding-x                                   | 1rem
 $nav-link-padding-y                                   | 0.5rem
 $nav-pills-border-radius                              | 0.25rem
 $nav-pills-link-active-bg                             | #007bff
 $nav-pills-link-active-color                          | #fff
 $nav-tabs-border-color                                | #dee2e6
 $nav-tabs-border-radius                               | 0.25rem
 $nav-tabs-border-width                                | 1px
 $nav-tabs-link-active-bg                              | #fff
 $nav-tabs-link-active-border-color                    | #dee2e6 #dee2e6 #fff
 $nav-tabs-link-active-color                           | #495057
 $nav-tabs-link-hover-border-color                     | #e9ecef #e9ecef #dee2e6
 $navbar-brand-font-size                               | 1.25rem
 $navbar-brand-height                                  | 1.875rem
 $navbar-brand-padding-y                               | 0.3125rem
 $navbar-dark-active-color                             | #fff
 $navbar-dark-brand-color                              | #fff
 $navbar-dark-brand-hover-color                        | #fff
 $navbar-dark-color                                    | rgba(255, 255, 255, 0.5)
 $navbar-dark-disabled-color                           | rgba(255, 255, 255, 0.25)
 $navbar-dark-hover-color                              | rgba(255, 255, 255, 0.75)
 $navbar-dark-toggler-border-color                     | rgba(255, 255, 255, 0.1)
 $navbar-dark-toggler-icon-bg                          | url("data:image/svg+xml,%3csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3e%3cpath stroke='rgba(255, 255, 255, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e")
 $navbar-light-active-color                            | #091017
 $navbar-light-brand-color                             | #091017
 $navbar-light-brand-hover-color                       | #091017
 $navbar-light-color                                   | #355b84
 $navbar-light-disabled-color                          | rgba(53, 91, 132, 0.7)
 $navbar-light-hover-color                             | #1f354d
 $navbar-light-toggler-border-color                    | rgba(53, 91, 132, 0.5)
 $navbar-light-toggler-icon-bg                         | url("data:image/svg+xml,%3csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3e%3cpath stroke='%23355b84' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e")
 $navbar-nav-link-padding-x                            | 1rem
 $navbar-newtalk-available                             | #007bff
 $navbar-newtalk-not-available                         | rgba(53, 91, 132, 0.7)
 $navbar-padding-x                                     | 1rem
 $navbar-padding-y                                     | 0.5rem
 $navbar-toggler-border-radius                         | 0.25rem
 $navbar-toggler-font-size                             | 1rem
 $navbar-toggler-padding-x                             | 0.5rem
 $navbar-toggler-padding-y                             | 0.1rem
 $navbar-user-loggedin                                 | #007bff
 $navbar-user-not-loggedin                             | rgba(53, 91, 132, 0.7)
 $nested-kbd-font-weight                               | 700
 $orange                                               | #fd7e14
 $overflows                                            | auto, hidden
 $pagination-active-bg                                 | #007bff
 $pagination-active-border-color                       | #007bff
 $pagination-active-color                              | #fff
 $pagination-bg                                        | #fff
 $pagination-border-color                              | #dee2e6
 $pagination-border-width                              | 1px
 $pagination-color                                     | #1b599b
 $pagination-disabled-bg                               | #fff
 $pagination-disabled-border-color                     | #dee2e6
 $pagination-disabled-color                            | #6c757d
 $pagination-focus-box-shadow                          | 0 0 0 0.2rem rgba(0, 123, 255, 0.25)
 $pagination-focus-outline                             | 0
 $pagination-hover-bg                                  | #e9ecef
 $pagination-hover-border-color                        | #dee2e6
 $pagination-hover-color                               | #10345a
 $pagination-line-height                               | 1.25
 $pagination-padding-x                                 | 0.75rem
 $pagination-padding-x-lg                              | 1.5rem
 $pagination-padding-x-sm                              | 0.5rem
 $pagination-padding-y                                 | 0.5rem
 $pagination-padding-y-lg                              | 0.75rem
 $pagination-padding-y-sm                              | 0.25rem
 $paragraph-margin-bottom                              | 1rem
 $pink                                                 | #e83e8c
 $popover-arrow-color                                  | #fff
 $popover-arrow-height                                 | 0.5rem
 $popover-arrow-outer-color                            | rgba(0, 0, 0, 0.25)
 $popover-arrow-width                                  | 1rem
 $popover-bg                                           | #fff
 $popover-body-color                                   | #212529
 $popover-body-padding-x                               | 0.75rem
 $popover-body-padding-y                               | 0.5rem
 $popover-border-color                                 | rgba(0, 0, 0, 0.2)
 $popover-border-radius                                | 0.3rem
 $popover-border-width                                 | 1px
 $popover-box-shadow                                   | 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2)
 $popover-font-size                                    | 0.875rem
 $popover-header-bg                                    | #f7f7f7
 $popover-header-color                                 | null
 $popover-header-padding-x                             | 0.75rem
 $popover-header-padding-y                             | 0.5rem
 $popover-max-width                                    | 276px
 $positions                                            | static, relative, absolute, fixed, sticky
 $pre-color                                            | #212529
 $pre-scrollable-max-height                            | 340px
 $primary                                              | #007bff
 $print-body-min-width                                 | 992px
 $print-page-size                                      | a3
 $progress-bar-animation-timing                        | 1s linear infinite
 $progress-bar-bg                                      | #007bff
 $progress-bar-color                                   | #fff
 $progress-bar-transition                              | width 0.6s ease
 $progress-bg                                          | #e9ecef
 $progress-border-radius                               | 0.25rem
 $progress-box-shadow                                  | inset 0 0.1rem 0.1rem rgba(0, 0, 0, 0.1)
 $progress-font-size                                   | 0.75rem
 $progress-height                                      | 1rem
 $purple                                               | #6f42c1
 $red                                                  | #dc3545
 $rfs-base-font-size                                   | 20
 $rfs-base-font-size-unit                              | rem
 $rfs-breakpoint                                       | 1200
 $rfs-breakpoint-unit                                  | px
 $rfs-breakpoint-unit-cache                            | px
 $rfs-class                                            | 0
 $rfs-factor                                           | 10
 $rfs-font-size-unit                                   | rem
 $rfs-rem-value                                        | 16
 $rfs-safari-iframe-resize-bug-fix                     | 0
 $rfs-two-dimensional                                  | 0
 $rounded-pill                                         | 50rem
 $secondary                                            | #6c757d
 $sizes                                                | (25: 25%, 50: 50%, 75: 75%, 100: 100%, auto: auto)
 $small-font-size                                      | 0.8
 $spacer                                               | 1rem
 $spacers                                              | (0: 0, 1: 0.25rem, 2: 0.5rem, 3: 1rem, 4: 1.5rem, 5: 3rem)
 $spinner-border-width                                 | 0.25em
 $spinner-border-width-sm                              | 0.2em
 $spinner-height                                       | 2rem
 $spinner-height-sm                                    | 1rem
 $spinner-width                                        | 2rem
 $spinner-width-sm                                     | 1rem
 $success                                              | #28a745
 $table-accent-bg                                      | rgba(0, 0, 0, 0.05)
 $table-active-bg                                      | rgba(0, 0, 0, 0.075)
 $table-bg                                             | null
 $table-bg-level                                       | -9
 $table-border-color                                   | #dee2e6
 $table-border-level                                   | -6
 $table-border-width                                   | 1px
 $table-caption-color                                  | #6c757d
 $table-cell-padding                                   | 0.75rem
 $table-cell-padding-sm                                | 0.3rem
 $table-color                                          | #212529
 $table-dark-accent-bg                                 | rgba(255, 255, 255, 0.05)
 $table-dark-bg                                        | #343a40
 $table-dark-border-color                              | #454d55
 $table-dark-color                                     | #fff
 $table-dark-hover-bg                                  | rgba(255, 255, 255, 0.075)
 $table-dark-hover-color                               | #fff
 $table-head-bg                                        | #e9ecef
 $table-head-color                                     | #495057
 $table-hover-bg                                       | rgba(0, 0, 0, 0.075)
 $table-hover-color                                    | #212529
 $table-striped-order                                  | odd
 $teal                                                 | #20c997
 $text-muted                                           | #6c757d
 $theme-color-interval                                 | 0.08
 $theme-colors                                         | ("primary": #007bff, "secondary": #6c757d, "success": #28a745, "info": #17a2b8, "warning": #ffc107, "danger": #dc3545, "light": #e9ecef, "dark": #343a40, "error": #dc3545, "darker": #ced4da)
 $thumbnail-bg                                         | #fff
 $thumbnail-border-color                               | #dee2e6
 $thumbnail-border-radius                              | 0.25rem
 $thumbnail-border-width                               | 1px
 $thumbnail-box-shadow                                 | 0 1px 2px rgba(0, 0, 0, 0.075)
 $thumbnail-caption-padding                            | 3px
 $thumbnail-padding                                    | 0.25rem
 $toast-background-color                               | rgba(255, 255, 255, 0.85)
 $toast-border-color                                   | rgba(0, 0, 0, 0.1)
 $toast-border-radius                                  | 0.25rem
 $toast-border-width                                   | 1px
 $toast-box-shadow                                     | 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1)
 $toast-color                                          | null
 $toast-font-size                                      | 0.875rem
 $toast-header-background-color                        | rgba(255, 255, 255, 0.85)
 $toast-header-border-color                            | rgba(0, 0, 0, 0.05)
 $toast-header-color                                   | #6c757d
 $toast-max-width                                      | 350px
 $toast-padding-x                                      | 0.75rem
 $toast-padding-y                                      | 0.25rem
 $tooltip-arrow-color                                  | #000
 $tooltip-arrow-height                                 | 0.4rem
 $tooltip-arrow-width                                  | 0.8rem
 $tooltip-bg                                           | #000
 $tooltip-border-radius                                | 0.25rem
 $tooltip-color                                        | #fff
 $tooltip-font-size                                    | 0.875rem
 $tooltip-margin                                       | 0
 $tooltip-max-width                                    | 200px
 $tooltip-opacity                                      | 0.9
 $tooltip-padding-x                                    | 0.5rem
 $tooltip-padding-y                                    | 0.25rem
 $transition-base                                      | all 0.2s ease-in-out
 $transition-collapse                                  | height 0.35s ease
 $transition-fade                                      | opacity 0.15s linear
 $warning                                              | #ffc107
 $white                                                | #fff
 $yellow                                               | #ffc107
 $yiq-contrasted-threshold                             | 150
 $yiq-text-dark                                        | #212529
 $yiq-text-light                                       | #fff
 $zindex-dropdown                                      | 1000
 $zindex-fixed                                         | 1030
 $zindex-modal                                         | 1050
 $zindex-modal-backdrop                                | 1040
 $zindex-popover                                       | 1060
 $zindex-sticky                                        | 1020
 $zindex-tooltip                                       | 1070

## Grid breakpoints

Variable: `$cmln-grid-breakpoints`

When overriding breakpoints you must either:
* include the default `cmln` breakpoint; or
* additionally set the NavbarHorizontal component's breakpoint variable `$cmln-navbar-horizontal-collapse-point` to one of the other breakpoint names

**Example: Without the `cmln` breakpoint and with the navbar breakpoint set to `lg` instead:**

```php
$egChameleonExternalStyleVariables = [
	'cmln-navbar-horizontal-collapse-point' => 'lg',
	'cmln-grid-breakpoints' => '(xs: 0, sm: 576px, md: 768px, lg: 992px, xl: 1900px)'
];
```

**Example: With the `cmln` breakpoint:**

```php
$egChameleonExternalStyleVariables = [
        'cmln-grid-breakpoints' => '(xs: 0, sm: 576px, md: 768px, lg: 992px, cmln: 1105px, xl: 1900px)'
];
```

In both cases the original `$cmln-collapse-point` variable used for setting the `cmln` breakpoint size will be ignored.

## Link formats

Variable: `$cmln-link-formats`

*Important*:
* This variable can currently only be overridden if the default theme is disabled or if
  a custom theme is used. Refer to the section on [Theme Customization](./customization.md#changing-styles-themes).
* Some of the link colors defined here might be overridden elsewhere.

This defines the link format for a few predefined MediaWiki link types: `new`, `stub`, `extiw`, `external`.

Each each link type can define 4 values corresponding to the parameters used by the
[`link()`](../resources/styles/_mixins.scss) mixin: `color`, `decoration`, `hover-color`, `hover-decoration`.
If all 4 values are provided they can just be listed. If only some values are provided they must be named.

**Example: Change 2 of the link formats**

 link type | `color`  | `decoration` | `hover-color` | `hover-decoration`
-----------|----------|--------------|---------------|--------------------
 new       | red      | underline    | blue          | none
 external  | green    | none         | brown         | underline

```php
$egChameleonExternalStyleVariables = [
	'cmln-link-formats' => '(new: red underline blue none, external: green none brown underline)'
];
```

**Example: Named values**

 link type | `color`  | `decoration` | `hover-color` | `hover-decoration`
-----------|----------|--------------|---------------|--------------------
 new       | #ff0000  | none         | #0000ff       | none
 external  | #00ff00  | none         | #a52a2a       | none

```php
$egChameleonExternalStyleVariables = [
        'cmln-link-formats' => "(new: ('color': #ff0000, 'hover-color': #0000ff), external: #00ff00 none #a52a2a none)"
];
```
