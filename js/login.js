new Vue({
    el:'#login',
    data:{
        username: "",
        password: "",
    },
    beforeCreate: function() {

	},
    methods:{
        login : function(){
            param = {
                "username": this.username,
                "password": this.password
            };
			$.ajax({
				url: "../farm_project/php/login.php",
				type: "POST",
				data: JSON.stringify(param),
				processData : false,
				context: this,
				contentType : "application/json"
            }).done(function(msg){
                let jsonmsg = JSON.parse( msg );
                if(jsonmsg.is_pass){
					$.cookie("token", jsonmsg.token);
					$.cookie("u_id", jsonmsg.u_id);
                    alert("登入成功");
                    location.reload();
                    
                }else{
                    //$.removeCookie("token");
					//$.removeCookie("u_id");
                    alert("帳號或密碼錯誤");
                }

			}).fail(function(jqXHR, textStatus) {
				console.log(textStatus);
				console.log(jqXHR.responseText);
			});	

        }
    }

});