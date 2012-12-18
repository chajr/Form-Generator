<h3>
                            <a href="#">
                                Base usage
                            </a>
                        </h3>
                        <div>
                            <h4>
                                Implementation of main files:
                            </h4>
                            <code>
                                <pre class="brush: php">
    &lt;&quest;php
    define('CORE_PARAM_SEPARATOR', '::');
    require_once 'Core/Xml.php';
    require_once 'Validator/Simple.php';
    require_once 'Forms/Form.php';
    &quest;&gt;</pre>
                            </code>
                            <p class="info">
                                CORE_PARAM_SEPARATOR is constant that is used in 
                                some attributes, that can contains more than one
                                value.
                                <span></span>
                            </p>
                            <h4>
                                Starting of libary:
                            </h4>
                            <code>
                                <pre class="brush: php">
    $form = new Forms_Form('some_definition');</pre>
                            </code>
                            <span>
                                Create Form object with xml definition.
                                <br/><br/>
                                Can have second parameter with array of definitions.
                                Described in next step.
                            </span>
                            <code>
                                <pre class="brush: php">
    echo $form->displayForm();</pre>
                            </code>
                            <span>
                                Display complete form.
                            </span>
                            <code>
                                <pre class="brush: php">
    $form->valid($_POST);</pre>
                            </code>
                            <span>
                                Method valid() validate the form with given array.
                                Method returns boolean information about validation 
                                progress.
                                <br/>
                                FALSE form has some errors, TRUE form ok
                            </span>
                            <code>
                                <pre class="brush: php">
    $form->errorList;</pre>
                            </code>
                            <span>
                                Contains informations about input errors.
                            </span>
                            <code>
                                <pre class="brush: php">
array(10) {
    ["input4"]=>
      array(2) {
        [0]=>
        string(8) "required"
        [1]=>
        string(7) "pattern"
      }
}</pre>
                            </code>
                            <span>
                                Example errorList data
                            </span>
                            <h4>
                                Full example:
                            </h4>
                            <code>
                                <pre class="brush: php">
    &lt;&quest;php
    $form = new Forms_Form('form_definition');
    if (!empty($_POST)) {
        $bool = $form->valid($_POST);
        if ($bool) {
            echo 'Form validated ok';
        } else {
            var_dump($form->errorList);
        }
    }
    echo $form->displayForm();
    &quest;&gt;</pre>
                            </code>
                        </div>