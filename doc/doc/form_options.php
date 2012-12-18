<h3>
                            <a href="#">
                                Forms_Form options
                            </a>
                        </h3>
                        <div>
                            <p>
                                User has possibility to configure library by giving
                                in constructor array of options.
                            </p>
                            <code>
                                <pre class="brush: php">
    $form = new Forms_Form($optionsArray, $listDefinition);</pre>
                            </code>
                            <span>
                                Adding options to library.
                            </span>
                            <code>
                                <pre class="brush: php">
    $form = new Forms_Form('some_definition', $listDefinition);</pre>
                            </code>
                            <span>
                                Running library without options.
                            </span>
                            <code>
                                <pre class="brush: php">
    $optionsArray = array(
        'input_error_class'         => 'inputError',
        'input_parent_error_class'  => 'input_error',
        'form_error_class'          => 'form_error',
        'attributes_to_hide'        => array(),
        'use_error_node'            => TRUE,
        'pattern_symbol'            => '#',
        'validation_class'          => 'Validator_Simple'
    );</pre>
                            </code>
                            <span>
                                Options Array
                            </span>
                            <h4>
                                Options description:
                            </h4>
                            <ul>
                                <li>
                                    input_error_class - name of css class added 
                                    to input with error
                                </li>
                                <li>
                                    input_parent_error_class - name of css class
                                    added to input (with error) parent node
                                </li>
                                <li>
                                    form_error_class - name of css class added to
                                    form element when was an error
                                </li>
                                <li>
                                    attributes_to_hide - array of input attributes
                                    taht wont be displayed on form output
                                </li>
                                <li>
                                    use_error_node - if set to TRUE uses special 
                                    nodes for input error information
                                </li>
                                <li>
                                    pattern_symbol - char used to create preg_match
                                    valid pattern
                                </li>
                                <li>
                                    validation_class - name of class to be used 
                                    for validation. Factory method witch choose
                                    specific methods to validate
                                </li>
                            </ul>
                        </div>