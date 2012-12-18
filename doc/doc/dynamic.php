<h3>
                            <a href="#">
                                Dynamic inputs
                            </a>
                        </h3>
                        <div>
                            <h4>
                                Creating and using dynamic inputs:
                            </h4>
                            <p>
                                Sometime user needs to send undefined number of
                                some fields (eg. file), this can be done using 
                                dynamic fields.<br/>
                                You define base validation of dynamic input in 
                                definition file, as normal input, but name of that 
                                input must end with [] (some_input[]).
                                Basic display will output one field, that can be 
                                cloned using javascript (all must have same name).
                                <br/>
                                When user sent form, validator will check all 
                                send fields, and if their was some errors check
                                correct field.
                            </p>
                            <div class="info">
                                All id of input must be changed by javascript,
                                or defined in list definition.
                                <span></span>
                            </div>
                            <code>
                                <pre class="brush: xml">
    &lt;p class="dynamic_inputs"&gt;
		&lt;label&gt;
			dynamic input
		&lt;/label&gt;
		&lt;input type="text" maxlength="20" name="dynamic_iput[]" 
            placeholder="Enter some text" required="required" 
            size="20" minlength="2" id="dynamic_iput" valid_type="string" 
        /&gt;
		&lt;dynamic_iput_error convert="span"&gt;
			dynamic field error
		&lt;/dynamic_iput_error&gt;
	&lt;/p&gt;
                                </pre>
                            </code>
                            <span>
                                Define dynamic input in xml
                            </span>
                            <div class="info">
                                Dynamic checkbox and radio buttons must have
                                hidden input with name: name_of_dynamic_input_jsonData,
                                for correct detect position and value of dynamic
                                element on list.
                                <br/>
                                That is used to correct selecting input with error
                                and set up value in correct input.
                                <span></span>
                            </div>
                            <code>
                                <pre class="brush: xml">
    &lt;p&gt;
        &lt;label&gt;
            dynamic checkbox
        &lt;/label&gt;
        &lt;input type="checkbox" name="chk[]" value="1"  min="1" max="10"/&gt;
        &lt;input type="hidden" name="chk_jsonData" value="1"/&gt;
        &lt;chk_error id="" class="" convert="span"&gt;
            checkbox error
        &lt;/chk_error&gt;
    &lt;/p&gt;
                                </pre>
                            </code>
                            <span>
                                Define dynamic checkbox in xml. 
                            </span>
                            <p>
                                When number of input to be diasplayed is changing,
                                you can define dynamic inputs in list definition
                                given to form constructor. Eg. when user send 
                                undefined fields to database, and now system must
                                show all of that fields.
                            </p>
                            <code>
                                <pre class="brush: xml">
    &lt;p class="dynamic_inputs"&gt;
		&lt;label&gt;
			dynamic input
		&lt;/label&gt;
		&lt;input type="text" maxlength="20" name="dynamic_iput[]" 
            placeholder="Enter some text" required="required" 
            size="20" minlength="2" id="dynamic_iput" valid_type="string" 
        /&gt;
		&lt;dynamic_iput_error convert="span"&gt;
			dynamic field error
		&lt;/dynamic_iput_error&gt;
	&lt;/p&gt;
                                </pre>
                                <pre class="brush: php">
    $definitionArray = array(
        'dynamic_iput' => array(
                array(
                    'value'     => 'a1',
                    'id'        => 'dynamic_iput_1'
                ),
                array(
                    'value'     => 'a2',
                    'id'        => 'dynamic_iput_2'
                ),
                array(
                    'value'     => 'a3',
                    'id'        => 'dynamic_iput_3'
                ),
            )
        )
    );
                                </pre>
                            </code>
                            <span>
                                Define dynamic inputs in list definition
                            </span>
                        </div>