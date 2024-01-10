<?php

/**
 * Provide a admin main page area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://mangwp.com
 * @since      1.0.0
 *
 * @package    Mangwp_Bricks
 * @subpackage Mangwp_Bricks/admin/partials
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

//Tab Bricks
$options = get_option($this->mangwp_bricks);
$mangwp_screenshot = (isset($options['mangwp_screenshot']) && !empty($options['mangwp_screenshot'])) ? 1 : 0;

$mangwp_body_attribute = (isset($options['mangwp_body_attribute']) && !empty($options['mangwp_body_attribute'])) ? 1 : 0;
$mangwp_main_attribute = (isset($options['mangwp_main_attribute']) && !empty($options['mangwp_main_attribute'])) ? 1 : 0;
$mangwp_header_attribute = (isset($options['mangwp_header_attribute']) && !empty($options['mangwp_header_attribute'])) ? 1 : 0;
$mangwp_footer_attribute = (isset($options['mangwp_footer_attribute']) && !empty($options['mangwp_footer_attribute'])) ? 1 : 0;

$mangwp_body_attributes = get_option('mangwp_body_attributes', array());
$mangwp_main_attributes = get_option('mangwp_main_attributes', array());
$mangwp_header_attributes = get_option('mangwp_header_attributes', array());
$mangwp_footer_attributes = get_option('mangwp_footer_attributes', array());

//Tab Wordpress
$mangwp_disable_gutenberg = isset($options['mangwp_disable_gutenberg']) ? $options['mangwp_disable_gutenberg'] : array();
$mangwp_set_views = isset($options['mangwp_set_views']) ? $options['mangwp_set_views'] : array();


?>
<div class="wrap">
    <h1 class="admin-notices-placeholder"></h1>

    <div class="bricks-admin-title-wrapper">
        <h1 class="title">General Utility</h1>
    </div>
    <ul id="mangwp-settings-tabs-wrapper" class="nav-tab-wrapper">
        <li><a href="#tab-general" class="nav-tab nav-tab-active" data-tab-id="tab-general">Bricks Builder</a></li>
        <li><a href="#tab-html-json" class="nav-tab" data-tab-id="tab-html-json">Connvert HTML to Bricks Json</a></li>
        <li><a href="#tab-wordpress" class="nav-tab" data-tab-id="tab-wordpress">Wordpress</a></li>
        <li><a href="#tab-snippet" class="nav-tab" data-tab-id="tab-snippet">Snippet</a></li>

    </ul>
    <form id="mangwp-settings" class="bricks-admin-wrapper" method="post" name="<?php echo $this->mangwp_bricks; ?>" action="options.php">
        <?php settings_fields($this->mangwp_bricks); ?>
        <div class="table-wrapper">
            <table id="tab-general" class="tab-content active">
                <tbody>
                    <tr>
                        <th>
                            <label for="mangwp_screenshot"><?php esc_attr_e('Screenshot', 'mangwp_bricks'); ?></label>
                            <p class="description">
                                <span><?php esc_attr_e('Add button on template frontend view to generate screenshot of template thumbnail', 'mangwp_bricks'); ?></span>
                            </p>
                        </th>
                        <td>
                            <label for="<?php echo $this->mangwp_bricks; ?>-mangwp_screenshot">
                                <input type="checkbox" id="<?php echo $this->mangwp_bricks; ?>-mangwp_screenshot" name="<?php echo $this->mangwp_bricks; ?>[mangwp_screenshot]" value="1" <?php checked($mangwp_screenshot, '1'); ?> />
                            </label>

                        </td>
                    </tr>
                    <tr class="row-repater body-attribute">
                        <th>
                            <label for="mangwp_body_attribute"><?php esc_attr_e('Body Attribute', 'mangwp_bricks'); ?></label>
                            <p class="description">
                                <span><?php esc_attr_e('Add attribute into "body" tag', 'mangwp_bricks'); ?></span>
                            </p>
                        </th>
                        <td>
                            <label for="<?php echo $this->mangwp_bricks; ?>-mangwp_body_attribute">
                                <input type="checkbox" id="<?php echo $this->mangwp_bricks; ?>-mangwp_body_attribute" name="<?php echo $this->mangwp_bricks; ?>[mangwp_body_attribute]" value="1" <?php checked($mangwp_body_attribute, '1'); ?> />
                            </label>

                            <table class="table-repater-items">
                                <thead>
                                    <tr>
                                        <td>Name</td>
                                        <td>Value</td>
                                        <td class="delete">Delete</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($mangwp_body_attributes as $attributes => $attribute) {
                                    ?>
                                        <tr>
                                            <td><input type="text" name="mangwp_body_attributes[<?php echo $attributes; ?>][body_name]" value="<?php echo esc_attr($attribute['body_name']); ?>"></td>
                                            <td><textarea name="mangwp_body_attributes[<?php echo $attributes; ?>][body_value]"><?php echo esc_textarea($attribute['body_value']); ?></textarea></td>
                                            <td class="delete"><button type="button" class="delete-row">x</button></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td> <span class="button">Add more </span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                    <tr class="row-repater main-attribute">
                        <th>
                            <label for="mangwp_main_attribute"><?php esc_attr_e('Main Attribute', 'mangwp_bricks'); ?></label>
                            <p class="description">
                                <span><?php esc_attr_e('Add attribute into "main" tag', 'mangwp_bricks'); ?></span>
                            </p>
                        </th>
                        <td>
                            <label for="<?php echo $this->mangwp_bricks; ?>-mangwp_main_attribute">
                                <input type="checkbox" id="<?php echo $this->mangwp_bricks; ?>-mangwp_main_attribute" name="<?php echo $this->mangwp_bricks; ?>[mangwp_main_attribute]" value="1" <?php checked($mangwp_main_attribute, '1'); ?> />
                            </label>

                            <table class="table-repater-items">
                                <thead>
                                    <tr>
                                        <td>Name</td>
                                        <td>Value</td>
                                        <td class="delete">Delete</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($mangwp_main_attributes as $attributes => $attribute) {
                                    ?>
                                        <tr>
                                            <td><input type="text" name="mangwp_main_attributes[<?php echo $attributes; ?>][main_name]" value="<?php echo esc_attr($attribute['main_name']); ?>"></td>
                                            <td><textarea name="mangwp_main_attributes[<?php echo $attributes; ?>][main_value]"><?php echo esc_textarea($attribute['main_value']); ?></textarea></td>
                                            <td class="delete"><button type="button" class="delete-row">x</button></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td> <span class="button">Add more </span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                    <tr class="row-repater header-attribute">
                        <th>
                            <label for="mangwp_header_attribute"><?php esc_attr_e('Header Attribute', 'mangwp_bricks'); ?></label>
                            <p class="description">
                                <span><?php esc_attr_e('Add attribute into "header" tag', 'mangwp_bricks'); ?></span>
                            </p>
                        </th>
                        <td>
                            <label for="<?php echo $this->mangwp_bricks; ?>-mangwp_header_attribute">
                                <input type="checkbox" id="<?php echo $this->mangwp_bricks; ?>-mangwp_header_attribute" name="<?php echo $this->mangwp_bricks; ?>[mangwp_header_attribute]" value="1" <?php checked($mangwp_header_attribute, '1'); ?> />
                            </label>

                            <table class="table-repater-items">
                                <thead>
                                    <tr>
                                        <td>Name</td>
                                        <td>Value</td>
                                        <td class="delete">Delete</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($mangwp_header_attributes as $attributes => $attribute) {
                                    ?>
                                        <tr>
                                            <td><input type="text" name="mangwp_header_attributes[<?php echo $attributes; ?>][header_name]" value="<?php echo esc_attr($attribute['header_name']); ?>"></td>
                                            <td><textarea name="mangwp_header_attributes[<?php echo $attributes; ?>][header_value]"><?php echo esc_textarea($attribute['header_value']); ?></textarea></td>
                                            <td class="delete"><button type="button" class="delete-row">x</button></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td> <span class="button">Add more </span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                    <tr class="row-repater footer-attribute">
                        <th>
                            <label for="mangwp_footer_attribute"><?php esc_attr_e('Footer Attribute', 'mangwp_bricks'); ?></label>
                            <p class="description">
                                <span><?php esc_attr_e('Add attribute into "footer" tag', 'mangwp_bricks'); ?></span>
                            </p>
                        </th>
                        <td>
                            <label for="<?php echo $this->mangwp_bricks; ?>-mangwp_footer_attribute">
                                <input type="checkbox" id="<?php echo $this->mangwp_bricks; ?>-mangwp_footer_attribute" name="<?php echo $this->mangwp_bricks; ?>[mangwp_footer_attribute]" value="1" <?php checked($mangwp_footer_attribute, '1'); ?> />
                            </label>

                            <table class="table-repater-items">
                                <thead>
                                    <tr>
                                        <td>Name</td>
                                        <td>Value</td>
                                        <td class="delete">Delete</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($mangwp_footer_attributes as $attributes => $attribute) {
                                    ?>
                                        <tr>
                                            <td><input type="text" name="mangwp_footer_attributes[<?php echo $attributes; ?>][footer_name]" value="<?php echo esc_attr($attribute['footer_name']); ?>"></td>
                                            <td><textarea name="mangwp_footer_attributes[<?php echo $attributes; ?>][footer_value]"><?php echo esc_textarea($attribute['footer_value']); ?></textarea></td>
                                            <td class="delete"><button type="button" class="delete-row">x</button></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td> <span class="button">Add more </span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div id="tab-html-json" class="tab-content html-json">
                <div class="flex-container">
                    <div class="flex-item">
                        <label for="htmlTextarea">HTML:</label>
                        <textarea id="htmlTextarea" name="htmlTextarea" rows="4" cols="50"><?php echo esc_textarea(get_option('textarea')); ?></textarea>
                    </div>

                    <div class="flex-item-middle">
                        <button type="button" class="button-with-arrow" onclick="convertToJSON()">
                            <span class="dashicons dashicons-arrow-right-alt"></span>
                        </button>
                    </div>

                    <div class="flex-item">
                        <label for="jsonTextarea">OUTPUT JSON:</label>
                        <textarea id="jsonTextarea" name="jsonTextarea" rows="4" cols="50"></textarea>
                    </div>
                </div>
                <script>
                    function convertToJSON() {
                        var htmlInput = document.getElementById('htmlTextarea').value;
                        var jsonOutput = convertHTMLtoJSON(htmlInput);
                        document.getElementById('jsonTextarea').value = JSON.stringify(jsonOutput, null, 2);
                    }

                    function convertHTMLtoJSON(html) {
                        var doc = document.createElement('div');
                        doc.innerHTML = html;

                        function generateRandomID() {
                            return 'id-' + Math.random().toString(36).substr(2, 10);
                        }

                        function capitalizeFirstLetter(string) {
                            return string.charAt(0).toUpperCase() + string.slice(1);
                        }

                        function convertElementToJSON(element, parentID) {
                            var jsonElement = {
                                id: element.id ? element.id.replace(/^brxe-/, '') : generateRandomID(),
                                parent: parentID || '',
                                name: element.tagName.toLowerCase(),
                                label: capitalizeFirstLetter(element.tagName.toLowerCase()), // Capitalize only the first letter
                                settings: {},
                                children: []
                            };

                            var classes = element.className.split(' ');
                            if (classes.length > 0) {
                                jsonElement.settings._cssGlobalClasses = classes;
                            }

                            var supportedTextTags = ['p', 'span', 'label', 'a'];
                            var tableRelatedTags = ['table', 'tr', 'thead', 'th', 'td', 'tfoot', 'tbody'];

                            if (element.tagName.toLowerCase() === 'a') {
                                if (element.children.length === 0) {
                                    jsonElement.name = 'text-link';
                                    jsonElement.settings.text = element.innerText.trim();
                                    jsonElement.label = 'Link'; // Set label to "Link" for anchor without children
                                } else {
                                    jsonElement.label = 'Link';
                                }
                            } else if (element.tagName.toLowerCase() === 'h1' ||
                                element.tagName.toLowerCase() === 'h2' ||
                                element.tagName.toLowerCase() === 'h3' ||
                                element.tagName.toLowerCase() === 'h4' ||
                                element.tagName.toLowerCase() === 'h5' ||
                                element.tagName.toLowerCase() === 'h6') {
                                if (element.children.length > 0) {
                                    jsonElement.name = 'div';
                                } else {
                                    jsonElement.name = 'heading';
                                }
                            } else if (element.tagName.toLowerCase() === 'img') {
                                jsonElement.name = 'image';
                                jsonElement.settings.image = {
                                    id: 113,
                                    filename: element.src.split('/').pop(),
                                    size: 'large',
                                    full: element.src,
                                    url: element.src
                                };
                            } else if (element.tagName.toLowerCase() === 'svg') {
                                jsonElement.name = 'svg';
                            } else if (supportedTextTags.includes(element.tagName.toLowerCase())) {
                                jsonElement.name = 'text-basic';
                            } else if (element.tagName.toLowerCase() === 'th') {
                                if (element.children.length === 0) {
                                    jsonElement.name = 'text-basic';
                                    jsonElement.settings.text = element.innerText.trim();
                                    jsonElement.settings.tag = element.tagName.toLowerCase();
                                } else {
                                    jsonElement.name = 'div';
                                }
                            } else if (element.tagName.toLowerCase() === 'td') {
                                if (element.children.length === 0) {
                                    jsonElement.name = 'text-basic';
                                    jsonElement.settings.text = element.innerText.trim();
                                    jsonElement.settings.tag = element.tagName.toLowerCase();
                                } else {
                                    jsonElement.name = 'div';
                                }
                            } else if (tableRelatedTags.includes(element.tagName.toLowerCase())) {
                                jsonElement.name = 'div';
                            }


                            if (element.tagName.toLowerCase() !== 'img' && element.tagName.toLowerCase() !== 'svg' && element.tagName.toLowerCase() !== 'th') {
                                jsonElement.settings.text = element.innerText.trim();
                                jsonElement.settings.tag = element.tagName.toLowerCase();

                                // Add all children ids
                                for (var i = 0; i < element.children.length; i++) {
                                    var child = element.children[i];
                                    jsonElement.children.push(child.id ? child.id.replace(/^brxe-/, '') : generateRandomID());
                                }
                            }

                            return jsonElement;
                        }


                        function assignChildIDs(element, parentID) {
                            for (var i = 0; i < element.children.length; i++) {
                                var child = element.children[i];
                                child.id = generateRandomID();
                                assignChildIDs(child, element.id.replace(/^brxe-/, ''));
                            }
                        }

                        assignChildIDs(doc, '');

                        var elements = Array.from(doc.querySelectorAll('*'));
                        var jsonElements = elements.map(element => convertElementToJSON(element, element.parentElement.id.replace(/^brxe-/, '')));

                        return {
                            content: jsonElements,
                            source: 'bricksCopiedElements',
                            sourceUrl: window.location.origin,
                            version: '1.9.4',
                            globalClasses: [],
                            globalElements: []
                        };
                    }
                </script>
            </div>

            <table id="tab-wordpress" class="tab-content">
                <tbody>
                    <tr>
                        <th>
                            <label for="mangwp_disable_gutenberg"><?php esc_attr_e('Disable Gutenberg', 'mangwp_bricks'); ?></label>
                            <p class="description">
                                <span><?php esc_attr_e('Disable Gutenberg in all places'); ?></span>
                            </p>
                        </th>
                        <td>
                            <?php
                            $post_types = get_post_types(['public' => true], 'objects');
                            // Inside the form, where you display the checkboxes
                            // Inside the form, where you display the checkboxes
                            foreach ($post_types as $post_type) {
                                $post_type_name = $post_type->name;
                                $checkbox_id = $this->mangwp_bricks . '-mangwp_disable_' . $post_type_name;
                                $checkbox_name = $this->mangwp_bricks . '[mangwp_disable_gutenberg][' . $post_type_name . ']'; // Update the name attribute
                                $checked = isset($mangwp_disable_gutenberg[$post_type_name]) && $mangwp_disable_gutenberg[$post_type_name] == '1';
                            ?>
                                <label for="<?php echo esc_attr($checkbox_id); ?>">
                                    <input type="checkbox" id="<?php echo esc_attr($checkbox_id); ?>" name="<?php echo esc_attr($checkbox_name); ?>" value="1" <?php checked($checked, true); ?> />
                                    <?php echo esc_html($post_type->label); ?>
                                </label><br>
                            <?php
                            }
                            // echo '<pre>';
                            // print_r($mangwp_disable_gutenberg);
                            // echo '</pre>';
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table id="tab-snippet" class="tab-content">
                <tbody>
                    <tr>
                        <th>
                            <label for="mangwp_lists_snippet"><?php esc_attr_e('List Snippets', 'mangwp_bricks'); ?></label>
                            <p class="description">
                                <span><?php esc_attr_e('List Snippet in all places'); ?></span>
                            </p>
                        </th>
                    </tr>
                    <?php
                    $json_directory = plugin_dir_path(__FILE__) . '../snippet/';
                    $json_files = glob($json_directory . '*.json');

                    foreach ($json_files as $json_file) {
                        $json_data = file_get_contents($json_file);
                        $snippet = json_decode($json_data, true);
                        $json_filename = basename($json_file);

                    ?>
                        <tr>
                            <td>
                                <?php echo esc_html($snippet['snippets'][0]['name']); ?>
                            </td>
                            <td>
                                <span class="preview-button button-link" data-code="<?php echo esc_attr($snippet['snippets'][0]['code']); ?>">Preview Code</span>
                            </td>
                            <td>
                                <span class="download-button button button-primary" data-json="<?php echo esc_attr($json_data); ?>" data-filename="<?php echo esc_attr($json_filename); ?>">Download JSON</span>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <div id="code-modal" class="modal-overlay">
                <div class="modal-content">
                    <div class="modal-header"><span id="copy-button" class="copy-button">Copy to Clipboard</span>
                        <div id="copy-notification">Code copied to clipboard!</div>
                    </div>
                    <pre id="code-preview"></pre>

                </div>
            </div>
            <style>
                /* Style for the modal overlay */
                .modal-overlay {
                    display: none;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.5);
                    justify-content: center;
                    align-items: center;
                }

                /* Style for the modal content */
                .modal-content {
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    width: 600px;
                    margin: auto;
                    height: 80vh;
                    overflow: scroll;
                    position: relative;
                }

                .copy-button {
                    display: inline-block;
                    padding: 5px 10px;
                    background-color: #007bff;
                    color: #fff;
                    border: none;
                    cursor: pointer;
                    border-radius: 4px;
                }

                #copy-notification {
                    display: none;
                    position: absolute;
                    top: 0px;
                    left: 50%;
                    transform: translateX(-50%);
                    background-color: #28a745;
                    color: #fff;
                    padding: 10px;
                    border-radius: 5px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    z-index: 1000;
                }
            </style>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var buttons = document.querySelectorAll('.preview-button');
                    var modal = document.getElementById('code-modal');
                    var codePreview = document.getElementById('code-preview');
                    var closeModalBtn = document.getElementById('close-modal-btn');
                    var copyButton = document.getElementById('copy-button');
                    var copyNotification = document.getElementById('copy-notification');

                    buttons.forEach(function(button) {
                        button.addEventListener('click', function() {
                            var code = this.getAttribute('data-code');
                            codePreview.textContent = code;
                            modal.style.display = 'flex';
                        });
                    });


                    modal.addEventListener('click', function(event) {
                        // Close the modal when clicking outside the modal-content
                        if (event.target === modal) {
                            modal.style.display = 'none';
                        }
                    });

                    copyButton.addEventListener('click', function() {
                        // Create a range, select the text content, and copy to clipboard
                        var range = document.createRange();
                        range.selectNode(codePreview);
                        window.getSelection().removeAllRanges();
                        window.getSelection().addRange(range);
                        document.execCommand('copy');
                        window.getSelection().removeAllRanges();

                        // Display the copy notification and hide it after 2 seconds
                        copyNotification.style.display = 'block';
                        setTimeout(function() {
                            copyNotification.style.display = 'none';
                        }, 2000);
                    });
                    var downloadButtons = document.querySelectorAll('.download-button');
                    downloadButtons.forEach(function(downloadButton) {
                        downloadButton.addEventListener('click', function() {
                            var jsonContent = this.getAttribute('data-json');
                            var filename = this.getAttribute('data-filename');

                            var blob = new Blob([jsonContent], {
                                type: 'application/json'
                            });
                            var a = document.createElement('a');
                            a.href = URL.createObjectURL(blob);
                            a.download = filename;
                            document.body.appendChild(a);
                            a.click();
                            document.body.removeChild(a);
                        });
                    });
                });
            </script>



        </div>
        <div class="submit-wrapper">
            <?php submit_button(__('Save all changes', 'mangwp_bricks'), 'primary', 'submit', true); ?>
        </div>

        <span class="spinner saving"></span>
    </form>
</div>