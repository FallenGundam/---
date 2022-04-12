var memberapp = new Vue({
    el:'#member',
    data:{
        region:"",
        phone:"",
        description:"",
        options: [
            { text: '臺北市' },
            { text: '基隆市' },
            { text: '宜蘭縣' },
            { text: '新北市' },
            { text: '連江縣' },
            { text: '新竹市' },
            { text: '新竹縣' },
            { text: '桃園市' },
            { text: '苗栗縣' },
            { text: '臺中市' },
            { text: '南投縣' },
            { text: '彰化縣' },
            { text: '嘉義市' },
            { text: '嘉義縣' },
            { text: '雲林縣' },
            { text: '臺南市' },
            { text: '澎湖縣' },
            { text: '金門縣' },
            { text: '高雄市' },
            { text: '屏東縣' },
            { text: '臺東縣' },
            { text: '花蓮縣' },
          ]

    },
    beforeCreate: function() {

	},
    mounted: function(){
        if($.cookie('token')!= undefined){
            param = {
                "u_id":$.cookie("u_id")
    
            };
            $.ajax({
                url: "../farm_project/php/loadmember.php",
                type: "POST",
                data: JSON.stringify(param),
                processData : false,
                context: this,
                contentType : "application/json"
            }).done(function(msg){
                let jsonmsg = JSON.parse( msg );
                if(jsonmsg.pass){
                    this.region=jsonmsg.region;
                    this.description=jsonmsg.description;
                    this.phone=jsonmsg.phone;
                }
                
    
    
            }).fail(function(jqXHR, textStatus) {
                console.log(textStatus);
                console.log(jqXHR.responseText);
            });	
        }



    },
    methods:{
        savedata : function(){
            param = {
                "location": this.region,
                "phone": this.phone,
                "description": this.description,
                "u_id":$.cookie("u_id")

            };
			$.ajax({
				url: "../farm_project/php/savemember.php",
				type: "POST",
				data: JSON.stringify(param),
				processData : false,
				context: this,
				contentType : "application/json"
            }).done(function(msg){
                alert(msg);
                window.location.reload();

			}).fail(function(jqXHR, textStatus) {
				console.log(textStatus);
				console.log(jqXHR.responseText);
			});	

        }

    }

});