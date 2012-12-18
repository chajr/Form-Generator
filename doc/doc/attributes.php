<h3>
    <a href="#">
        Attributes
    </a>
</h3>
<div>
    <h4>
        Input attributes description:
    </h4>
    <ul>
        <li class="info">
            <b>maxlength</b> - maximum given characters in value
            <span></span>
        </li>
        <li class="info">
            <b>name</b> - name of input, most important attribute
            each input is detected by this attribute value.
            if name has [] chars is defined as dynamic input.
            (name="input", name="dynamic[]")
            <span></span>
        </li>
        <li class="info">
            <b>pattern</b> - you can give regular expression 
            pattern to check value. Overrides other validation
            informations.
            (#[A-z]+#)
            <span></span>
        </li>
        <li class="info">
            <b>required</b> - input must be filled with some value, 
            or be checked is a radio or checkbox, or selected
            if is a select. if required attribute must have 
            "required" value.
            <span></span>
        </li>
        <li class="info">
            <b>step</b> - number step value
            <span></span>
        </li>
        <li class="info">
            <b>value</b> - input value
            <span></span>
        </li>
        <li class="info">
            <b>minlength</b> - minimum length of given chars
            <span></span>
        </li>
        <li class="info">
            <b>valid_type</b> - code with validation type of input.
            <span></span>
            <div class="info">
                <div class="info">
                    all codes used in Validator_Simple library
                    <span></span>
                </div>
                Example:
                <ul>
                    <li>
                        string - '#^[\p{L}]*$#u'
                    </li>
                    <li>
                        'letters' - '#^[\p{L} _ ,.-]*$#u'
                    </li>
                    <li>
                        'integer' - '#^[\\d]*$#',
                    </li>
                    <li>
                        'num_chars' - '#^[\p{L}\\d\\.,_-]*$#u',
                    </li>
                </ul>
                <span></span>
            </div>
        </li>
        <li class="info">
            <b>valid_dependency</b> - dependencies from other inputs.
            as value you give other input name. If input 
            with valid_dependency set up is filled, input
            given in valid_dependency must be filled.
            <span></span>
            <div class="info">
                You can add more than one field, separated 
                by given in constructor value separator
                <span></span>
            </div>
        </li>
        <li class="info">
            <b>check_field</b> - check value with other input.
            Basic used in define password on register
            form. First element is other input name, second
            is 0 or 1 that define error type. If is set to 1
            and values are same will return check_field_true
            error, if different no error. If is set to 0
            and fields are different will return check_field_false
            error, if same no error.
            <span></span>
        </li>
        <li class="info">
            <b>escape</b> - if set to TRUE value first use 
            mysqli_escape_string function on value, 
            then check their length
            <span></span>
        </li>
        <li class="info">
            <b>entities</b> - if set to TRUE value first use 
            htmlentities function on value, 
            then check their length
            <span></span>
        </li>
        <li class="info">
            <b>max</b> - used in numeric inputs to check maximum
            range of numeric field.<br/>
            (color as hex - #ffffff, date - 2012-12-12, 
            datetime - 2011-12-05 18:54)
            <span></span>
        </li>
        <li class="info">
            <b>min</b> - used in numeric inputs to check minimum
            range of numeric field.<br/>
            (color as hex - #ffffff, date - 2012-12-12, 
            datetime - 2011-12-05 18:54)
            <span></span>
        </li>
        <li class="info">
            <b>other_val</b> - name of method to return value.
            Example from databese or session.
            <span></span>
        </li>
        <li class="info">
            <b>type</b> - define type of input with HTML5. 
            Used in validation. If type is emial, check 
            if field is valid emial, if color check color
            given in hex format (#ffffff)
            <span></span>
        </li>
        <li class="info">
            <b>check_value</b> - compare input value with given
            in attribute value. If values are different
            return an error 
            <span></span>
        </li>
        <li class="info">
            <b>check_callback_value</b> - compare input value 
            using given in attribute function. If values 
            are different return an error.
            <span></span>
            <div class="info">
                Function must be a static function.
                <br/>
                ClassName::methodToCompare
                <span></span>
            </div>
        </li>
    </ul>
    <h4>
        Form attributes description:
    </h4>
    <ul>
        <li class="info">
            <b>novalidate</b> - if attribute has value 
            novalidate="novalidate" all inputs in form 
            will be not validated
            <span></span>
        </li>
    </ul>
    <h4>
        Error nodes attributes description:
    </h4>
    <ul>
        <li class="info">
            <b>convert</b> - type of node that node will be converted
            <span></span>
        </li>
    </ul>
</div>