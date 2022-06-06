


let p_id = new URL(location.href).searchParams.get('p_id');
let img_total = 6;
let img_default_src = "img/upload_icon.svg";

var load;
window.addEventListener("beforeunload", function (e) {
    if (!load){
        var confirmationMessage = "你還沒有完成你的文章，就這樣離開了嗎？";

        (e || window.event).returnValue = confirmationMessage; //Gecko + IE
        return confirmationMessage;                            //Webkit, Safari, Chrome
    }

});

//從資料庫同步的資料
let model = {
    p_id,
    u_id: $.cookie("u_id"),
    img_src: [],  //image_src
    type: "蔬菜", //product type select
    city: "",
    districts: "",
    name: "",
    price: 0,
    unit: "公斤",
    amount: 1,
    trade_type: "面交",
    introduction: "",
};


let product_edit = new Vue({
    el: '#product_edit',
    data: {

        data_model: {},

        //image_src
        img_data: [], //上傳圖片會用到


        //location select
        city_data: {},
        id_search: null,




    },
    beforeCreate: function () {
    },
    created: function () {

    },
    beforeMount: function () {
        let thisobj = this;
        $.getJSON("./json_data/CityData.json",
            function (data, textStatus, jqXHR) {
                thisobj.city_data = data;
                //console.log(thisobj.city_data[0].name);
                //console.log(thisobj.city_data[0].districts[0].name);
                //console.log(thisobj.city_data);
            }
        );


        //決定圖片總量


        if (p_id != null) {
            let self = this;
            let id = `p_id=${p_id}`;
            $.ajax({
                type: "GET",
                url: "../farm_project/php/product_manage/get_product.php",
                data: id,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    let temparr = response.img_src.split(',');
                    self.data_model = response;
                    self.data_model.img_src = temparr;
                    for (let index = 0; index < img_total; index++) {
                        const element = self.data_model.img_src[index];
                        if (element == '' || typeof element == 'undefined') {
                            self.data_model.img_src[index] = img_default_src;
                        } else {
                            self.data_model.img_src[index] = "img_data/" + element;
                        }

                    }
                    self.auto_select_type();



                }
            });
        } else {
            this.data_model = model;
            for (let index = 0; index < img_total; index++) {
                this.data_model.img_src.push(img_default_src);
            }

        }

    },
    mounted: function () {
        this.auto_select_type();

    },

    computed: {

    },

    watch: {

    },

    methods: {

        //圖片預覽

        //input點擊事件
        img_upload_click: function (event, index) {
            let thisdiv = event.currentTarget;
            // thisdiv.childNodes.forEach(element => {
            //     if (element.id == index){
            //         element.click();
            //     }    
            // });

            $(thisdiv).children('input').click();
        },
        //監聽使用者上傳的資料
        img_input_event: function (e, index) {

            let file = e.target.files.item(0);
            //console.log(file);
            const reader = new FileReader();
            if (file.type.includes("image")) {

                try {
                    this.img_data.forEach(element => {
                        if (element.name.includes(file.name)) {
                            throw new Error("無法上傳重複圖片")
                        }
                    });
                } catch (error) {
                    alert(error.message);
                    return;
                }

                if (file.size / 1024 / 1024 < 3) {
                    this.img_data[index] = file;
                    reader.readAsDataURL(file);
                    reader.onload = () => {
                        this.$set(this.data_model.img_src, index, reader.result);
                        // this.img_src[index] = reader.result;
                        // this.img_preview = reader.result;
                    };
                } else {
                    alert("檔案過大");
                }

            } else {
                alert("請使用圖片");
            }
        },

        img_delete: function (index) {
            this.img_data.splice(index);
            this.$set(this.data_model.img_src, index, img_default_src);

        },







        //選擇商品類型
        select_type: function (event) {
            //console.log(event.target);
            //console.log(event.currentTarget);
            let typeblock = event.currentTarget;
            this.data_model.type = $(typeblock).children('p').text();
            $(typeblock).siblings().removeClass('type_selected_effect');
            $(typeblock).addClass('type_selected_effect');


        },

        auto_select_type: function () {
            let thisobj = this;
            $("#typeblock").children().each(function () {
                let childrenDiv = this;
                let typetext = $(childrenDiv).children('p').text();
                if (typetext.includes(thisobj.data_model.type)) {
                    $(childrenDiv).addClass('type_selected_effect');
                }
            });
        },




        //選擇出貨地區
        SetCurrentLocation: function (event) {
            let finded = false;
            this.city_data.forEach(city => {
                city.districts.forEach(dis => {
                    if (dis.zip == this.id_search) {
                        this.data_model.city = city.name;
                        this.data_model.districts = dis.name;
                        finded = true;
                    }
                });
            });
            if (!finded) {
                alert("該號碼不存在");
            }
        },
        ResetLocation: function () {
            this.data_model.districts = null;
            this.id_search = null;
        },
        GetDistrictsList: function () {
            for (let index = 0; index < this.city_data.length; index++) {
                const element = this.city_data[index];
                if (element.name.includes(this.data_model.city)) {
                    return this.city_data[index].districts;
                }

            }
        },






        savedata: function () {

            if (this.data_model.img_src[0].includes(img_default_src)) {
                alert("圖片封面請勿留白");
                $body.animate
                return;
            }
            if (this.data_model.name.trim().length <= 0) {
                document.querySelector('#p_name').focus();
                document.querySelector('#p_name_msg').innerHTML = '<p>請輸入名稱</p>'
                return;
            }
            if (this.data_model.introduction.trim().length < 10) {
                document.querySelector('#p_text').focus();
                document.querySelector('#p_text_msg').innerHTML = '<p>字數必須大於20</p>'
                return;
            }
            if (this.data_model.city == "" || this.data_model.districts == "") {
                document.querySelector('#p_city').focus();
                document.querySelector('#p_city_msg').innerHTML = '<p>請選擇地區</p>'
                return;
            }
            if (this.data_model.price <= 0 || this.data_model.unit == "") {
                alert("表單尚未填完");
                return;
            }

            let temp_formdata = new FormData();

            //儲存已上傳的相片
            for (let index = 0; index < img_total; index++) {
                const element = this.img_data[index];
                if (element !== 'undefined') {
                    if (index == 0) {
                        temp_formdata.append('first_img', element);
                    } else {
                        temp_formdata.append('newimg[]', element);
                    }
                }
            }


            //紀錄未更換的圖片名
            this.data_model.img_src.forEach(e => {
                if (e.length < 1000 && !e.includes(img_default_src)) {
                    temp_formdata.append('oldsrc[]', e);
                }
            });
            console.log(temp_formdata.getAll('oldsrc[]'));


            //紀錄其他資料
            delete this.data_model.img_src;
            const jsoned = JSON.stringify(this.data_model);
            temp_formdata.append("data_model", jsoned);
            console.log(temp_formdata.get('data_model'));
            $('#loadingModal').modal('show');
            $.ajax({
                url: "../farm_project/php/product_manage/p_uploadFile.php",
                type: "POST",
                data: temp_formdata,
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#myModal').modal('hide');
                    let back = confirm("上傳成功,是否繼續上傳其他商品?");
                    load = true;
                    if (back) {
                        location.href = "product_edit.html";
                    } else {
                        location.href = "product_manage.html";
                    }
                }
            });





        },









    }
});