<h3>
    <a href="#">
        Errors description
    </a>
</h3>
<div>
    <h4>
        Form errors
    </h4>
    <div class="info">
        Forms_form has two attributes with errors.<br/>
        Class errors are written in $error attribute.<br/>
        Form inputs errors are written in $errorList attribute.
        <span></span>
    </div>
    <p>
        Array of errors returned by Forms_Form object
    </p>
    <ul class="errors">
        <li>
            <b>numeric</b> - number validation was incorrect (default pattern: #^(-)?[\d]*$#)
            <span></span>
        </li>
        <li>
            <b>mail</b> - email address was incorrect (default pattern: #^[\w_\.-]*[\w_]@[\w_\.-]*\.[\w_-]{2,3}$#e)
            <span></span>
        </li>
        <li>
            <b>url_full</b> - url address was incorrect (default pattern: #^((http|https|ftp|ftps)://)?[\w\._/-]+(\?[\w&%=+-]*)?$#)
            <span></span>
        </li>
        <li>
            <b>hex_color</b> - hexadecimal color number was incorrect (default pattern: /^#[\da-f]{6}$/i)
            <span></span>
        </li>
        <li>
            <b>date</b> - date was incorrect (default pattern: #^[\d]{4}-[\d]{2}-[\d]{2}$#)
            <span></span>
        </li>
        <li>
            <b>week</b> - week number was incorrect (default pattern: #^[\d]{4}-[\d]{2}$#)
            <span></span>
        </li>
        <li>
            <b>range_min_year</b> - year range was to low
            <span></span>
        </li>
        <li>
            <b>range_min_week</b> - week range was to low
            <span></span>
        </li>
        <li>
            <b>range_max_year</b> - year range was to big
            <span></span>
        </li>
        <li>
            <b>range_max_week</b> - week range was to big
            <span></span>
        </li>
        <li>
            <b>time</b> - time number was incorrect (default pattern: #^[\d]{2}:[\d]{2}(:[\d]{2})?$#)
            <span></span>
        </li>
        <li>
            <b>month</b> - time number was incorrect (default pattern: #^[\d]{4}-[\d]{2}$#)
            <span></span>
        </li>
        <li>
            <b>date_range_conversion</b> - date cant be converted using strtotime php function
            <span></span>
        </li>
        <li>
            <b>range_max</b> - value is too big
            <span></span>
        </li>
        <li>
            <b>range_min</b> - value is too small
            <span></span>
        </li>
        <li>
            <b>phone</b> - time number was incorrect (default pattern: #^((\+)[\d]{2})?( ?\( ?[\d]+ ?\) ?)?[\d -]*$#)
            <span></span>
        </li>
        <li>
            <b>step</b> - difference between numbers is incorrect
            <span></span>
        </li>
        <li>
            <b>reqiured</b> - input must have some value
            <span></span>
        </li>
        <li>
            <b>pattern</b> - value is incorrect, checked with given input pattern
            <span></span>
        </li>
        <li>
            <b>minlength</b> - length of value is too small
            <span></span>
        </li>
        <li>
            <b>maxlength</b> - length of value is too big
            <span></span>
        </li>
        <li>
            <b>valid_type</b> - value is incorrect, checked with given type validation
            from Validation library
            <span></span>
        </li>
        <li>
            <b>check_field_true</b> - compared value with other input is same<br/>
            (check_field_true::input_name)
            <div class="info">
                If set to same value will be incorrect 
                <span></span>
            </div>
            <span></span>
        </li>
        <li>
            <b>check_field_false</b> - compared value with other input is different<br/>
            (check_field_false::input_name)
            <div class="info">
                If set to different value will be incorrect 
                <span></span>
            </div>
            <span></span>
        </li>
        <li>
            <b>compare</b> - value of input is not the same that given in attribute
            <span></span>
        </li>
        <li>
            <b>callback_compare</b> - value of input is not the same that is checked in callback function
            <span></span>
        </li>
        <li>
            <b>range_max</b> - value range is too big
            <span></span>
        </li>
        <li>
            <b>range_min</b> - value range is too small
            <span></span>
        </li>
        <li>
            <b>similar</b> - values are too similar
            <span></span>
        </li>
    </ul>
    <h4>
        Classes errors
    </h4>
    <p>
        Forms_Form class
    </p>
    <ul class="errors">
        <li>
            <b>definition_none_exist</b> - no xml definition found
            <span></span>
        </li>
        <li>
            <b>callback_class_not_defined</b> - class to compare
            valeues not find (probably not loaded)
            <span></span>
        </li>
    </ul>
    <p>
        Core_Xml class errors, returned by Forms_Form::$error
    </p>
     <ul class="errors">
        <li>
            <b>dont_exist</b> - xml fine not found
            <span></span>
        </li>
        <li>
            <b>loading</b> - error when reading xml file
            <span></span>
        </li>
        <li>
            <b>parse</b> - error when checking xml file with dtd
            <span></span>
        </li>
    </ul>
</div>