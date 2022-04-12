var signup = new Vue({
    el:'#signup',
    data:{
        username: "",
        mail: "",
        password: "",
        password2: "",
        message: ""
    },
    mounted: function(data) {
		
	},
    methods:{
        checkmail : function(){

            if (this.username.indexOf(" ")!=-1){
                alert('存在非法字元');
            }
            else{
                if (this.password.replace(/(^s*)|(s*$)/g, "").length == 0) {
                    alert('請輸入密碼');
                }
                else
                {
                    var myreg = /^[^\[\]\(\)\\<>:;,@.]+[^\[\]\(\)\\<>:;,@]*@[a-z0-9A-Z]+(([.]?[a-z0-9A-Z]+)*[-]*)*[.]([a-z0-9A-Z]+[-]*)+$/g;
                    if(myreg.test(this.mail) == false)
                    {
                        alert('請輸入有效的E_mail');
                    }
                    else{
                        if(this.password==this.password2){
                            this.signup();
                        }
                        else{
                            alert('密碼必須一致')
                        }
                        
                    }
                }
            }

            
        },
        signup : function(){
            param = {
                "username": this.username,
                "mail": this.mail,
                "password": this.password
              };
            $.ajax({
				url: "../farm_project/php/signup.php",
				type: "POST",
				data: JSON.stringify(param),
                datatype: 'json',
				processData : false,
				context: this,
				contentType : "application/json" 
                
            }).done(function(msg) {

                
				if(msg=="true")
				{
                    alert("註冊成功 請返回登入!");
                    location.href="index.html";
					this.message = "註冊成功";
                    //$.cookie("token", jsonmsg.token);
					//$.cookie("u_id", jsonmsg.u_id);
				}
                else
				{
                    alert("該帳號已被註冊");
					this.message = "註冊失敗";
				}

			}).fail(function(jqXHR, textStatus) {
				console.log(textStatus);
				console.log(jqXHR.responseText);
			});		
        }
    }
});