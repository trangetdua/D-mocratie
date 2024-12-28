<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

    <header class="main">
        <nav class="navbar">
            <div class="icon">
                <img src="images/logo.png" alt="Logo" class="logo">
            </div>

            <div class="menu">
                <ul>
                    <li><a href="./index.html">HOME</a></li>
                    <li><a id="cart">AIDE</a></li>
                    <li><a id="aide">A PROPOS</a></li>
                    <li><a id="connect"><img src="./images/client.png" alt="client" class="client"></a></li>
                </ul>
            </div>
        </nav>
    </header> 


 <section class="hero">

        <div class="content-wrapper">
            
            <div class="content-left">
                <h1> YOUR VOTE <br><span class="content-span"> OUR FUTURE </span></h1>
            </div>

            <div class="content-right">
                <h2 class="form-title">CONNEXION</h2>
                <?php if (isset($_GET['identifiant']) && $_GET['identifiant'] == "faux"): ?>
                    <p style="color: red;">Identifiant ou mot de passe incorrect.</p>
                <?php endif; ?>
                
                <form class="reservation-form" action="login.php" method="post">
                    <div class="form-group">
                        <label for="email">Adresse mail : </label>
                        <input type="email" id="email" name="email" placeholder="Votre adresse mail">

                        <label for="password">Password : </label>
                        <input type="password" id="password" name="password" placeholder="Votre mot de passe">
                    </div>
                    <h4>Votre première connexion ? </h4>
                    <a href="register.php" class="signup-link">Créer un compte</a>

                    <button type="submit">Connecter</button>
                </form>
            </div>
        </div>
    
    </section>


    <?php include 'footer.html'; ?>
    

</body>
</html>
