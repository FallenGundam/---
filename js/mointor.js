//控制上方面板顯示

var mointor = new Vue({
    el:'#mointor',
    data:{
        canlogin:true,
        canlogout:false,
        message:""
     

    },
    beforeCreate: function() {
        

	},

    mounted: function(){
        if($.cookie('token')!= undefined)
		{
			this.message=$.cookie("token");
            this.canlogin=false;
            this.canlogout=true;
		}
        else{
            this.message="";
            this.canlogin=true;
            this.canlogout=false;
        }
        
    },


    methods:{
        logout : function(){
            alert("成功登出");
            $.removeCookie("token");
            $.removeCookie("u_id");
            location.href="index.html";
        }
    }

});