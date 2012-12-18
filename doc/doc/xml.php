<h3>
                            <a href="#">
                                Build xml definition
                            </a>
                        </h3>
                        <div>
                            <p>
                                In xml file you can create complete form code,
                                including all html elements that form will have.
                                Error containers, some descriptions and others 
                                needed in structure elements.
                                <br/>
                                Xml library process only inputs elements, 
                                and special blocks for errors.
                            </p>
                            <h4>
                                Base usage:
                            </h4>
                            <code>
                                <pre class="brush: xml">
    &lt;?xml version="1.0" encoding="UTF-8"?&gt;
    &lt;!DOCTYPE root SYSTEM "form.dtd"&gt;
        &lt;form method="post" name="form" action="" accept-charset="utf-8" target="_self"&gt;
            &lt;p&gt;
                &lt;label&gt;
                    Base form
                &lt;/label&gt;
                &lt;input type="text" name="first" required="required" valid_type="string"/&gt;
                &lt;input type="text" name="second" required="required" valid_type="integer"/&gt;
            &lt;/p&gt;
        &lt;/form&gt;
                                </pre>
                            </code>
                            <span>
                                Base form definition, working wits 2 inputs.<br/>
                                First input validate string, next numbers.
                            </span>
                            <h4>
                                With error information
                            </h4>
                            <div class="info">
                                Error element for input must consist from input name
                                with _error (&lt;input_name_error&gt;) and attribute 
                                that indicate type of element to be node converted.
                                In example convert="span" node will be converted
                                in span element.
                                <br/>
                                Error node can contains other html nodes.
                                <span></span>
                            </div>
                            <code>
                                <pre class="brush: xml">
    &lt;?xml version="1.0" encoding="UTF-8"?&gt;
    &lt;!DOCTYPE root SYSTEM "form.dtd"&gt;
        &lt;form method="post" name="form" action="" accept-charset="utf-8" target="_self"&gt;
            &lt;p&gt;
                &lt;label&gt;
                    Base form
                &lt;/label&gt;
                &lt;input type="text" name="first" required="required" valid_type="string"/&gt;
                &lt;input type="text" name="second" required="required" valid_type="integer"/&gt;
                &lt;first_error convert="span"&gt;Error from first input&lt;/first_error&gt;
                &lt;second_error convert="span"&gt;Error from second input&lt;/second_error&gt;
            &lt;/p&gt;
        &lt;/form&gt;
                                </pre>
                            </code>
                            <span>
                                Error node will be contained special element
                                with error information like {;error_code;}.
                            </span>
                            <h4>
                                Dynamic checkbox
                            </h4>
                            <div class="info">
                                Must have special hidden input with name of input 
                                with _jsonData (main_input_jsonData), to check 
                                witch input must be selected when will be again 
                                displayed.
                                <span></span>
                            </div>
                            <div class="info">
                                Used in dynamic checkbox and radio buttons.
                                <span></span>
                            </div>
                            <code>
                                <pre class="brush: xml">
    &lt;?xml version="1.0" encoding="UTF-8"?&gt;
    &lt;!DOCTYPE root SYSTEM "form.dtd"&gt;
        &lt;form method="post" name="form" action="" accept-charset="utf-8" target="_self"&gt;
            &lt;label&gt;
                dynamic checkbox
            &lt;/label&gt;
            &lt;input type="checkbox" height="20" width="7" name="chk[]" size="20" value="1" id="" style="" class="" min="1" max="10"/&gt;
            &lt;input type="hidden" name="chk_jsonData" value="1"/&gt;
            &lt;chk_error convert="span"&gt;
                checkbox error
            &lt;/chk_error&gt;
        &lt;/form&gt;
                                </pre>
                            </code>
                        </div>