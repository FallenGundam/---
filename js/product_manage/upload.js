var uploadapp = new Vue({
    el:'#upload',
    data:{
        image: '',


        name: "",
        price: 0,
        unit: "",
        city: "",
        text: "",
        amount:1



    },
    mounted: function(data) {
		
	},
    methods:{

    



        fileSelected(e) {
            const file = e.target.files.item(0);
            const reader = new FileReader();
            reader.addEventListener('load', this.imageLoaded);
            reader.readAsDataURL(file);
          },
        imageLoaded(e)
        {
            this.image = e.target.result;
        },





        dataupload:function(){

            let thisobj=this;
            let newimg = document.getElementById("the_file").files[0];
            let form_data = new FormData();
            form_data.append('the_file',newimg);
            $.ajax({
				url: "../farm_project/php/product_manage/uploadimg.php",
				type: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                
            }).done(function(msg) {
                thisobj.upload(msg);


			}).fail(function(jqXHR, textStatus) {
				console.log(textStatus);
				console.log(jqXHR.responseText);
			});	
        },

        upload :function(picturename){
 
            param = {
                "name": this.name,
                "price": this.price,
                "unit": this.unit,
                "city": this.city,
                "text": this.text,
                "amount": this.amount,
                "u_id": $.cookie("u_id"),
                "picture": picturename
              };
            $.ajax({
				url: "../farm_project/php/product_manage/upload.php",
				type: "POST",
				data: JSON.stringify(param),
                datatype: 'json',
				processData : false,
				context: this,
				contentType : "application/json" 
                
            }).done(function(msg) {
                alert(msg);
                location.reload();


			}).fail(function(jqXHR, textStatus) {
				console.log(textStatus);
				console.log(jqXHR.responseText);
			});	



        }
        
        
    }
});