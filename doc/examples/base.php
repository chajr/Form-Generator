<h3>
                            <a href="#">
                                Base Example
                            </a>
                        </h3>
                        <div>
                            <?php 
                            $baseForm = new Forms_Form('base_example');
                            if (isset($_POST['form_type']) && $_POST['form_type'] === 'base_example') {
                                echo '<script>selectedExample = \'base_example\'</script>';
                                $bool = $baseForm->valid($_POST);
                                if (!$bool) {
                                    echo '<code><pre>';
                                    var_dump($baseForm->errorList);
                                    echo '</pre></code><span>list of errors</span>';
                                } else {
                                    echo '<div class="ok">
                                        form ok
                                    </div>';
                                }
                            }?>
                            <fieldset class="baza">
                                <legend>
                                    Base Example
                                </legend>
                                <?php
                                echo $baseForm->displayForm();
                                ?>
                            </fieldset>
                            <div class="button" rel="php_block">
                                Show PHP code
                            </div>
                            <div class="php_block">
                                <code>
                                    <pre class="brush: php">
    $baseForm = new Forms_Form('base_example');
    if (isset($_POST['form_type']) && $_POST['form_type'] === 'base_example') {
        $bool = $baseForm->valid($_POST);
        if (!$bool) {
            echo '&lt;code&gt;&lt;pre&gt;';
            var_dump($baseForm->errorList);
            echo '&lt;/pre&gt;&lt;/code&gt;';
        } 
    }
    echo $baseForm->displayForm();</pre>
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
    &lt;form method="post" action="" accept-charset="utf-8" target="_self"&gt;
        &lt;p&gt;
            &lt;input type="hidden" name="form_type" value="base_example"/&gt;
            &lt;label&gt;
                text input
            &lt;/label&gt;
            &lt;input type="text" name="input1" placeholder="Enter some text" required="required" value="" minlength="2" valid_type="string" /&gt;
            &lt;input1_error convert="span"&gt;Input 1 Error&lt;/input1_error&gt;
        &lt;/p&gt;
        &lt;p&gt;
            &lt;label&gt;
                number input
            &lt;/label&gt;
            &lt;input type="number" name="input2" placeholder="Enter some numbers" required="required" value="" minlength="2" valid_type="integer" max="50" maxlength="20" min="-50"
            /&gt;
            &lt;input2_error convert="span"&gt;Input 2 Error&lt;/input2_error&gt;
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