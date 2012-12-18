<h3>
    <a href="#">
        Required files
    </a>
</h3>
<div>
    <h4>
        There are few files required to use Forms package:
    </h4>
    <ul>
        <li>
           Forms/Form.php - main Form class 
        </li>
        <li>
            Core/Xml.php - used to maniplulate xml 
            files (extends DOMDocument)
        </li>
        <li>
            Validator/Simple.php - library to 
            validate inputs
        </li>
        <li>
            some xml file with input definition 
            (xml/some_definition.xml)
        </li>
    </ul>
    <p class="info">
        All libraries don't has any private methods 
        or properties so can be extended to use in 
        different ways.
        <span></span>
    </p>
    <a href="download.php" class="download">
        Download
        <br/>
        <span>
            Version: <?php echo $version[0]; ?>
        </span>
    </a>
</div>