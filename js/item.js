


var currentURL = new URL(location.href);
let p_id = currentURL.searchParams.get('p_id')

var item = new Vue({
    el: '#item',
    data: {
        item_data: {
            img_src: []
        },

        sneak_json: [],
        seller_data:[]
    },


    beforeMount: function () {


        let self = this;
        $.ajax({
            url: "../farm_project/php/product_manage/get_product.php",
            type: "GET",
            data: `p_id=${p_id}`,
            processData: false,
            context: this,
            dataType: "json",
        }).done(function (response) {
            let temparr = response.img_src.split(',');
            self.item_data = response;
            self.item_data.img_src = temparr;
            for (let index = 0; index < temparr.length; index++) {
                const element = self.item_data.img_src[index];
                if (element == '' || typeof element == 'undefined') {
                    self.item_data.img_src[index] = img_default_src;
                } else {
                    self.item_data.img_src[index] = "img_data/" + element;
                }
            }
            self.search_json();
            self.load_product_member(self.item_data.u_id);


        }).fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            console.log(jqXHR.responseText);
        });


    },
    mounted: function () {


    },

    methods: {
        change_First_img: function (index) {
            document.querySelector('#first_img').src = this.item_data.img_src[index];
        },

        time_com: function () {
            let temp = typeof this.item_data.date !== 'undefined' ? this.item_data.date : "Te-st";
            let jsDate = new Date(Date.parse(temp.replace(/-/g, '/')));
            let now = new Date();
            let r = Math.abs((now.getTime() - jsDate.getTime())) / (1000 * 60 * 60 * 24);
            let str = "天前";
            if (r < 1) {
                r = r * 24;
                str = "小時前";
                if (r<1){
                    r=r*60;
                    str = "分鐘前";
                }
            }
            return Math.floor(r) + str;

        },

        //獲取賣家訊息
        load_product_member:function (u_id) {  
            let self = this;
            $.ajax({
                type: "GET",
                url: "../farm_project/php/loadmember.php",
                data: `u_id=${u_id}`,
                dataType: "json",
                success: function (response) {
                    self.seller_data = response
                    self.seller_data.img = "img_data/member/" +response.img;
                    //console.log(response);
                }
            });
        },

        







        //向開放資料平台抓取行情價
        search_json: function () {
            let main_keywords = this.item_data.name;
            //let key1 = this.item_data.city.substring(0,2);
            //let key2 = this.item_data.districts.substring(0,2);
            let finalkey = `CropName=${main_keywords}`
            let self = this;
            $.ajax({
                type: "GET",
                data: finalkey,
                url: "https://data.coa.gov.tw/api/v1/AgriProductsTransType/",
                // 農產品產地價格資料 "https://data.coa.gov.tw/Service/OpenData/TransService.aspx?UnitId=WVOiWSdDjWxx"
                // 農產品類別名稱代號 "https://data.coa.gov.tw/Service/OpenData/TransService.aspx?UnitId=LC7YWlenhLuP"
                dataType: "json",
                success: function (response) {
                    //console.log(response);
                    response.Data.forEach(element => {
                        if (element.CropName != '休市') {
                            self.sneak_json.push(element);
                            // console.log(element);
                        }
                    });

                }
            });
        }


    },





});
