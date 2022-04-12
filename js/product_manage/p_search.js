

//此腳本包刮商品管理

var p_search = new Vue({
    el:'#p_search',
    data:{
        searchstr:"",
        namelist:[],
        currentitem:[],




        name: "",
        price: 0,
        unit: "",
        city: "",
        text: "",
        imgsrc:"",
        amount:0






    },
    beforeCreate: function() {
        if($.cookie('token')== undefined){
            self.location.href='index.html';
        }

	},
    mounted: function(){
        this.search();
    },
    methods:{

        
        search : function(){
            
            param = {
                "u_id": $.cookie("u_id"),
                "searchstr": this.searchstr
            };
			$.ajax({
				url: "../farm_project/php/product_manage/p_search.php",
				type: "POST",
				data: JSON.stringify(param),
				processData : false,
				context: this,
				contentType : "application/json"
            }).done(function(msg){
                this.namelist=[];
                let jsonmsg = JSON.parse( msg );
                
                for (let index = 0; index < jsonmsg.length; index++) {
                    let msgg = JSON.parse(jsonmsg[index]);
                    this.namelist.push(msgg);
                }
                
  
			}).fail(function(jqXHR, textStatus) {
				console.log(textStatus);
				console.log(jqXHR.responseText);
			});	

        },

        deletedata : function(){

            param = {
                "imgsrc": this.imgsrc,
                "p_id": this.editing

            };
			$.ajax({
				url: "../farm_project/php/product_manage/p_deletedata.php",
				type: "POST",
				data: JSON.stringify(param),
				processData : false,
				context: this,
				contentType : "application/json"
            }).done(function(msg){
                alert(msg);
                location.reload();
                
  
			}).fail(function(jqXHR, textStatus) {
				console.log(textStatus);
				console.log(jqXHR.responseText);
			});	



        },
        savedata :function(){

            param = {
                "name": this.name,
                "price": this.price,
                "unit": this.unit,
                "city": this.city,
                "text": this.text,
                "amount": this.amount,
                "p_id": this.editing
            };
			$.ajax({
				url: "../farm_project/php/product_manage/p_savedata.php",
				type: "POST",
				data: JSON.stringify(param),
				processData : false,
				context: this,
				contentType : "application/json"
            }).done(function(msg){
                alert(msg);
                location.reload();

                
  
			}).fail(function(jqXHR, textStatus) {
				console.log(textStatus);
				console.log(jqXHR.responseText);
			});	




        },

        selectedit : function(event){
            //console.log(event.target.value);
            this.editing=event.target.value;

            param = {
                "u_id": $.cookie("u_id"),
                "p_id": event.target.value
            };
			$.ajax({
				url: "../farm_project/php/product_manage/get_product.php",
				type: "POST",
				data: JSON.stringify(param),
				processData : false,
				context: this,
				contentType : "application/json"
            }).done(function(msg){
                let jsonmsg = JSON.parse( msg );
                this.name=jsonmsg.name;
                this.price=jsonmsg.price;
                this.unit=jsonmsg.unit;
                this.city=jsonmsg.city;
                this.amount=jsonmsg.amount;
                this.text=jsonmsg.text;
                this.imgsrc="img_data/"+jsonmsg.imgsrc;
                
  
			}).fail(function(jqXHR, textStatus) {
				console.log(textStatus);
				console.log(jqXHR.responseText);
			});	


        }



    }

});