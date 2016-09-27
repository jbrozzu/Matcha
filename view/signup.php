<body>
            <div class="corpus">
            
                <div class="form">
                    <form action="{{ path_for('user.signup') }}" method="post" >
                        <label for="name"> Pseudo </label>
                        <input type="text" name="name" id="name" autofocus required />
                        <br />
                        <label for="email"> E-mail </label>
                        <input type="text" name="email" id="email" required />
                        <br />
                        <label for="pass"> Mot de passe </label>
                        <input type="password" name="pass" id="pass" required />
                        <br />
                        <label for="cpass"> Confirmation </label>
                        <input type="password" name="cpass" id="cpass" required />
                        <br /><br />
                        <input type="submit" value="ENVOYER" />      
                    </form>
                </div>

            </div>

    </body>