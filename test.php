<?php
session_start();
    if($_GET["lang"] == "En"){
        $_SESSION["lang"] = "En";
        header("Location: index.php");
    }
    if($_GET["lang"]== "Fr"){
        $_SESSION["lang"] = "Fr";
        header("Location: index.php");
    }
