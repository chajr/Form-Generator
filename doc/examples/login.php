<h3>
                            <a href="#">
                                Login Form
                            </a>
                        </h3>
                        <div>
                            <?php 
                            require_once 'Validator/Password.php';
                            $options = array(
                                'form'                      => 'login_form',
                                'input_error_class'         => NULL,
                                'input_parent_error_class'  => NULL
                            );
                            $definition = array(
                                'email'	=> array(
                                    'check_value' => 'user@web.com'
                                )
                            );
                            $loginForm = new Forms_Form($options, $definition);
                            if (isset($_POST['form_type']) && $_POST['form_type'] === 'login_form') {
                                echo '<script>selectedExample = \'login_form\'</script>';
                                $bool = $loginForm->valid($_POST);
                                if (!$bool) {
                                    echo '<code><pre>';
                                    var_dump($loginForm->errorList);
                                    echo '</pre></code><span>list of errors</span>';
                                } else {
                                    echo '<div class="ok">
                                        form ok
                                    </div>';
                                }
                            }?>
                            <fieldset class="baza">
                                <legend>
                                    Log in Form Example
                                </legend>
                                <?php
                                echo $loginForm->displayForm();
                                ?>
                            </fieldset>
                            <div class="button" rel="php_block">
                                Show PHP code
                            </div>
                            <div class="php_block">
                                <code>
                                    <pre class="brush: php">
    require_once 'Validator/Password.php';
    $options = array(
        'form'                      => 'login_form',
        'input_error_class'         => NULL,
        'input_parent_error_class'  => NULL
    );
    $definition = array(
        'email'	=> array(
            'check_value' => 'user@web.com'
        )
    );
    $loginForm = new Forms_Form($options, $definition);
    if (isset($_POST['form_type']) && $_POST['form_type'] === 'login_form') {
        $bool = $loginForm->valid($_POST);
        if (!$bool) {
            echo '&lt;code&gt;&lt;pre&gt;';
            var_dump($loginForm->errorList);
            echo '&lt;/pre&gt;&lt;/code&gt;';
        } 
    }
    echo $loginForm->displayForm();</pre>
                                </code>
                                <span>
                                    php code
                                </span>
                            </div>
                            <div class="button" rel="valid_block">
                                Show Validator_Password code
                            </div>
                            <div class="valid_block">
                                <code>
                                    <pre class="brush: php">
    class Validator_Password{
        static $passwordToCheck = 'somePassword';
        static function check ($pass)
        {
            if (md5($pass) === md5(self::$passwordToCheck)) {
                return TRUE;
            }
            return FALSE;
        }
    }</pre>
                                </code>
                                <span>
                                    php code
                                </span>
                            </div>
                            <div class="button" rel="xml_block">
                                Show XML code
                            </div>
                            <div class="xml_block">
                                <code>
                                    <pre class="brush: xml">
    &lt;?xml version="1.0" encoding="UTF-8"?&gt;
    &lt;!DOCTYPE root SYSTEM "form.dtd"&gt;
    &lt;form method="post" class="form" action="" accept-charset="utf-8" target="_self"&gt;
        &lt;p&gt;
            &lt;label&gt;
                Login:
            &lt;/label&gt;
            &lt;input type="hidden" name="form_type" value="login_form"/&gt;
            &lt;input type="email" name="email" placeholder="Enter E-mail" 
                required="required" value="" minlength="5" 
                valid_type="mail"
            /&gt;
        &lt;/p&gt;
        &lt;p&gt;
            &lt;label&gt;
                Password
            &lt;/label&gt;
            &lt;input type="password" name="pass" placeholder="Enter Password" 
                maxlength="20" required="required" minlength="2" 
                valid_type="num_chars" check_callback_value="Validator_Password::check"
            /&gt;
        &lt;/p&gt;
        &lt;p&gt;
            &lt;email_error convert="span" class="input_error"&gt;
                Login or email was incorrect.
            &lt;/email_error&gt;
            &lt;pass_error class="input_error" convert="span"&gt;
                Login or email was incorrect.
            &lt;/pass_error&gt;
        &lt;/p&gt;
        &lt;p&gt;
            &lt;input type="submit" value="submit"/&gt;
        &lt;/p&gt;
    &lt;/form&gt;
                                    </pre>
                                </code>
                                <span>
                                    xml code
                                </span>
                            </div>
                        </div>