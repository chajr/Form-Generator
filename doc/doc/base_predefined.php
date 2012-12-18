<h3>
                            <a href="#">
                                Base usage with predefined elements
                            </a>
                        </h3>
                        <div>
                            <p>
                                Every input attribute can be changed by list definition
                                given in Form constructor as second parameter.
                                <br/>
                                List definition can also create dynamic inputs by 
                                cloning defined in xml file element, each next element 
                                must have declaration in array. If you want 5
                                dynamic input you must declare in array 5 elements.
                                <br/>
                            </p>
                            <p class="info">
                                You can't create new inputs by that list definition.
                                All elements must be declare in xml file. 
                                <span></span>
                            </p>
                            <code>
                                <pre class="brush: php">
    $definition = array(
        'input1'	=> array('value' => 'some value'),
        'input2'	=> array(
            'value' => 'other value',
            'class' => 'input_class'
        ),
        'checkbox'    => array(
            'checked' => 'checked',
            'class'   => 'chka_class',
            'required'=> 'required'
        ),
        'input3'    => array(
            'disabled'   => 'disabled'
        )
    }
    $form = new Forms_Form('form_definition', $definition);</pre>
                            </code>
                            <span>
                                Override attributes given in xml definition.
                            </span>
                            <code>
                                <pre class="brush: php">
    $definition = array(
        'dynamic_input' => array(
            array(
                'value'     => '1',
                'id'        => 'dynamic_input_1'
            ),
            array(
                'value'     => '2',
                'id'        => 'dynamic_input_2'
            ),
            array(
                'value'     => '3',
                'id'        => 'dynamic_input_3'
            )
        )
    }
    $form = new Forms_Form('form_definition', $definition);</pre>
                            </code>
                            <span>
                                Create 3 dynamic inputs with given values and id.
                            </span>
                        </div>