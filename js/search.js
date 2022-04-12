

var searchapp = new Vue({
    el:'#search',
    data:{
        search_str: "",
        itemlist:[],

        currentitem:[]


    },

    methods: {

        newserch:function(){
            if(this.search_str==""){
                alert('請輸入關鍵字');
            }else{

                param = {
                    "search_str": this.search_str
                };
                $.ajax({
                    url: "../farm_project/php/home_search.php",
                    type: "POST",
                    data: JSON.stringify(param),
                    processData : false,
                    context: this,
                    contentType : "application/json"
                }).done(function(msg){
                    this.itemlist=[];
                    //console.log(msg);
                    let jsonmsg = JSON.parse( msg );
                    
                    console.log(jsonmsg.length);
                    if (jsonmsg.length>0){
                        for (let index = 0; index < jsonmsg.length; index++) {
                            let item = JSON.parse(jsonmsg[index]);
                            
                            item.imgsrc="img_data/"+item.imgsrc;
                            this.itemlist.push(item);
                        }
                    }else{
                        alert("查無資料");
                    }
                    
                    
                    
    
                }).fail(function(jqXHR, textStatus) {
                    console.log(textStatus);
                    console.log(jqXHR.responseText);
                });	
            }


        },

        viewfunction:function(event){
            console.log(event.target.value);
            let pid=event.target.value;
            //搜尋已有資料表中 pid相同的物件
            for (let index = 0; index < this.itemlist.length; index++) {
                if(this.itemlist[index].p_id == pid){
                    this.currentitem=this.itemlist[index];  //瀏覽頁面暫存
                    break;
                }
            }
            console.log(this.currentitem.name);
        }











    },

});

