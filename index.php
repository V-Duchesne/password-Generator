<?php
require_once 'vendor/autoload.php';
$faker = Faker\Factory::create();
session_start();
if(!isset($_SESSION["lang"])){
    $_SESSION["lang"] = "Fr";
}
if($_SESSION["lang"] == "Fr"){
    $_SESSION['title'] = "Générateur de mot de passe / pseudo";
    $_SESSION['nick'] = "Générer un pseudo";
    $_SESSION['pass'] = "Générer un mot de passe";
    $_SESSION['lengthPass'] = "Longueur du mot de passe";
    $_SESSION['lengthPassPH'] = "De 6 a 128 caractères";
    $_SESSION['symbol'] = "Inclure des symboles";
    $_SESSION['number'] = "Inclure des nombres";
    $_SESSION['lowercase'] = "Inclure des minuscules";
    $_SESSION['uppercase'] = "Inclure des Majuscules";
    $_SESSION['generate'] = "Générer";
    $_SESSION['copy'] = "Copier";
    $_SESSION['placeHolder'] = "Votre mot de passe sera généré ici";
    $_SESSION['errorLength'] = "le mot de passe doit contenir entre 6 et 128 caractères";
    $_SESSION['choiceError'] = "Choisissez au moin une option";
    $_SESSION['en'] = 'Anglais';
    $_SESSION['fr'] = 'Français';
}
if($_SESSION["lang"] == "En"){
    $_SESSION['title'] = "Password / nickname generator";
    $_SESSION['nick'] = "Generate a nickname";
    $_SESSION['pass'] = "Generate a password";
    $_SESSION['lengthPass'] = "Password length";
    $_SESSION['lengthPassPH'] = "6 to 128 characters";
    $_SESSION['symbol'] = "Include symbols";
    $_SESSION['number'] = "Include numbers";
    $_SESSION['lowercase'] = "Include lowercase";
    $_SESSION['uppercase'] = "Include uppercase";
    $_SESSION['generate'] = "Generate";
    $_SESSION['copy'] = "Copy";
    $_SESSION['placeHolder'] = "Your password will be generated here";
    $_SESSION['errorLength'] = "Password must be between 6 and 128 characters";
    $_SESSION['choiceError'] = "Choose at least one option";
    $_SESSION['en'] = 'English';
    $_SESSION['fr'] = 'French';
}
if(isset($_POST["flexRadioDefault"]) && $_POST["flexRadioDefault"] == "username"){
    $_SESSION["check"] = "checked";
    $user1=$faker->word();
    $user2=$faker->word();
    $user3=$faker->randomNumber(3,false);
    $username = $user1;
    if(rand(0,1) == 1){
        $username = $username."_";
    }
    if(rand(0,1) == 1){
        $username = $username.$user2;
    }
    if(rand(0,1) == 1){
        $username = $username.$user3;
    }
    $mdp=$username;
}else
if(isset($_POST["length"]) && !is_null($_POST["length"])){
    $length = $_POST["length"];
    $_SESSION['length'] = $length;
    if($length < 6 || $length > 128){
        $_SESSION['lengthError'] = $_SESSION['errorLength'];
    }else{
        $mdp = generatePassword($length);
    }
}
function generatePassword($length){
    $symbol = '{}[]()/\~;:<>@!*%';
    $number = '0123456789';
    $lowercase = 'abcdefghijklmnopqrstuvwxyz';
    $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $chars = '';
    if(!isset($_POST['symbol']) && !isset($_POST['number']) && !isset($_POST['lowercase']) && !isset($_POST['uppercase']) && $_POST['flexRadioDefault'] == "password"){
        $_SESSION['noChoice'] = $_SESSION['choiceError'];
    }else{
        if(isset($_POST['symbol'])){
            $chars = $chars.$symbol;
        }
        if(isset($_POST['number'])){
            $chars = $chars.$number;
        }
        if(isset($_POST['lowercase'])){
            $chars = $chars.$lowercase;
        }
        if(isset($_POST['uppercase'])){
            $chars = $chars.$uppercase;
        }
        $pass = array();
        $charsLength = strlen($chars) -1;

        for ($i = 0; $i <$length; $i++){
            $n = rand(0, $charsLength);
            $pass[] = $chars[$n];
        }
        return implode($pass);
    }
}
    function languageSelect($lang){
        if($lang == "En"){
            $_SESSION["lang"] = "En";
            header("Location: index.php");
        }
        if($lang == "Fr"){
            $_SESSION["lang"] = "Fr";
            header("Location: index.php");
        }
    }
?>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://kit.fontawesome.com/03b7b463ab.js" crossorigin="anonymous"></script>
<script>
    function copy(){
        let copyText = document.getElementById("mdp");
        copyText.select();
        copyText.setSelectionRange(0,99999);
        navigator.clipboard.writeText(copyText.value);
    }
    function darkmode() {
        var element = document.body;
        element.classList.toggle("dark-mode");
        var element2 = document.getElementById("preform");
        element2.classList.toggle("preformBGDM");
    }
</script>
<style>
    .dark-mode {
        background-color: black;
        color: white;
    }
    .preformBG {
        background-color: lightgray;
    }
    .preformBGDM {
        background-color: grey;
    }
    header{
        height: 3rem;
        align-items: center;
    }
    .decorate:link, a:visited{
        color:black;
        text-decoration: none;
    }
    .decorate:hover{
        color:white;
    }
    .align{
        margin-top: 10%;
    }
</style>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<header class="d-flex bg-secondary justify-content-between">
    <h3 class="mx-3"><?php echo $_SESSION['title'] ?></h3>
    <div class="mx-3">
            <a href="test.php?lang=En" class="decorate"><?php echo $_SESSION['en'] ?></a> / <a href="test.php?lang=Fr" class="decorate me-4"><?php echo $_SESSION['fr'] ?></a>
        <button onclick="darkmode()"><i class="far fa-lightbulb"></i></button>
    </div>
</header>
<section>
    <div class="d-flex align">
        <div class="preformBG mx-auto p-4 rounded-3" id="preform">
            <form action="" method="POST">
                <div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="username">
                        <label class="form-check-label" for="flexRadioDefault1">
                            <?php echo $_SESSION['nick'] ?>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="password" checked>
                        <label class="form-check-label" for="flexRadioDefault2">
                            <?php echo $_SESSION['pass'] ?>
                        </label>
                    </div>
                </div>
                <div>
                    <div class="password selectt">
                        <label for="length" class="d-block"><?php echo $_SESSION['lengthPass'] ?></label>
                        <?php if(isset($_SESSION['lengthError'])) echo "<div class='text-danger'>".$_SESSION['lengthError']."</div>"?>
                        <input type="text" id="length" placeholder="<?php echo $_SESSION['lengthPassPH'] ?>" name="length" value="<?php if(isset($_SESSION['length']))echo $_SESSION["length"]?>">
                    </div>
                    <?php if(isset($_SESSION['noChoice'])) echo "<div class='text-danger'>".$_SESSION['noChoice']."</div>"?>
                    <div class="form-check password selectt">
                        <input class="form-check-input" type="checkbox" value="symbol" id="flexCheckDefault" checked name="symbol">
                        <label class="form-check-label" for="flexCheckDefault">
                            <?php echo $_SESSION['symbol'] ?>
                        </label>
                    </div>
                    <div class="form-check password selectt">
                        <input class="form-check-input" type="checkbox" value="number" id="flexCheckDefault" checked name="number">
                        <label class="form-check-label" for="flexCheckDefault">
                            <?php echo $_SESSION['number'] ?>
                        </label>
                    </div>
                    <div class="form-check password selectt">
                        <input class="form-check-input" type="checkbox" value="lowercase" id="flexCheckDefault" checked name="lowercase">
                        <label class="form-check-label" for="flexCheckDefault">
                            <?php echo $_SESSION['lowercase'] ?>
                        </label>
                    </div>
                    <div class="form-check password selectt">
                        <input class="form-check-input" type="checkbox" value="uppercase" id="flexCheckDefault" checked name="uppercase">
                        <label class="form-check-label" for="flexCheckDefault">
                            <?php echo $_SESSION['uppercase'] ?>
                        </label>
                    </div>
                </div>
                <div>
                    <input type="submit" value="<?php echo $_SESSION['generate'] ?>">
                </div>
                <div>
                    <label for="" class="d-block"><?php echo $_SESSION['placeHolder'] ?></label>
                    <input type="text" id="mdp" readonly value="<?php if(isset($mdp))echo $mdp?>">
                    <button type="button" onClick="copy()"><?php echo $_SESSION['copy'] ?></button>
                </div>
            </form>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('input[type="radio"]').click(function() {
                        var inputValue = $(this).attr("value");
                        var targetBox = $("." + inputValue);
                        $(".selectt").not(targetBox).hide();
                        $(targetBox).show();
                    });
                });
            </script>
        </div>
    </div>
</section>
</body>
</html>
<?php $_SESSION['noChoice'] = null;
$_SESSION['lengthError'] = null;
$_SESSION['length'] = null;