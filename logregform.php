<div class="form">
        <ul class="tab-group">
            <li class="tab"><a href="#signup">Sign Up</a></li>
            <li class="tab active"><a href="#login">Log In</a></li>
        </ul>
        <div class="tab-content">
            <div id="login">   
                <form id="loginform" name="loginform" onsubmit="return login_validation();" method="post" autocomplete="off">
                    <div class="field-wrap">
                        <label>
                            Email Address<span class="req">*</span>
                        </label>
                        <input type="text" autocomplete="off" name="email" id="email"/>
                    </div>
                    <div class="field-wrap">
                        <label>
                            Password<span class="req">*</span>
                        </label>
                        <input type="password" autocomplete="off" name="password" id="password"/>
                    </div>
					
					<div class="field-wrap">					
						<div class="g-recaptcha" align="center" data-sitekey="6LfkJ08UAAAAAMlS-2HXGELlUTlwjt7Eh6NNpWMp"></div>
					</div>
                    <span id="login_message"></span>
                    <button class="button button-block" name="login" id="login"/>Log In</button>
					<p></p>
					
					<div class="forgot"><a href="forgot.php">Forgot Password?</a> </div>
                </form>
            </div>
            <div id="signup">   
                <p>Complete all fields to sign up and gain access to all website content. It's free!</p>      
                <form id="registerform" name="registerform" onsubmit="return signup_validation();" method="post" autocomplete="off">
                    <div class="field-wrap">
                        <label>
                            First Name<span class="req">*</span>
                        </label>
                        <input type="text" autocomplete="off" name='firstname' id='firstname'/>
                    </div>  
                    <div class="field-wrap">
                        <label>
                            Last Name<span class="req">*</span>
                        </label>
                        <input type="text" autocomplete="off" name='lastname' id='lastname'/>
                    </div>
                    <div class="field-wrap">
                        <label>
                            Email Address<span class="req">*</span>
                        </label>
                        <input type="text" autocomplete="off" name='remail' id='remail'/>
                    </div>        
                    <div class="field-wrap">
                        <label>
                            Password<span class="req">*</span>
                        </label>
                        <input type="password" autocomplete="off" name='rpassword' id='rpassword'/>
                    </div>
					<div class="field-wrap">					
						<div class="g-recaptcha" align="center" data-sitekey="6LfkJ08UAAAAAMlS-2HXGELlUTlwjt7Eh6NNpWMp"></div>
					</div>
                    <span id="signup_message"></span>
                    <button type="submit" class="button button-block" name="register" id="register"/>Register</button>       
                </form>
            </div>        
        </div>
	</div>
    
		