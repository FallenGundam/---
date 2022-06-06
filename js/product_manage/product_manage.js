


// 數據模型
// alldata[0].p_name
// 'p_id'
// 'p_name' => ""
// 'img_src' => ""
// 'p_price' => ""
// 'p_date' => ""
// 'p_amount' => ""

let pagetotal = 12;

let product_getall = new Vue({
    el: '#product_manage',
    data: {

        alldata: [],

        u_id: $.cookie("u_id"),
        All_page: 0,
        current_page: 1,
        search_name: "",
        search_type: "",
        count:0

    },
    beforeCreate: function () {
    },
    created: function () {
    },
    beforeMount: function () {
        this.get_product();
    },
    mounted: function () {


    },
    computed: {
    },
    watch: {
    },


    methods: {
        get_product: function () {
            let self = this;
            let requestText = `u_id=${this.u_id}&pagetotal=${pagetotal}&page=${this.current_page}`;
            if (this.search_name.trim() !== "") {
                requestText = requestText + `&keywords=${this.search_name}`;
            }
            if (this.search_type !== "") {
                requestText = requestText + `&type=${this.search_type}`;
            }
            $.ajax({
                type: "GET",
                url: "../farm_project/php/product_manage/p_managelist.php",
                data: requestText,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response.found) {
                        self.All_page = Math.ceil(response.count / pagetotal);
                        for (let index = 0; index < response.list.length; index++) {
                            response.list[index] = JSON.parse(response.list[index]);
                            if (response.list[index].img_src.includes('notfound')) {
                                response.list[index].img_src = "background-image:url(img/upload_icon.svg)";
                            } else {
                                response.list[index].img_src = `background-image:url(img_data/${response.list[index].img_src})`;
                            }
                        }
                        self.count = response.count;
                        self.alldata = response.list;
                    }else{
                        self.count=0;
                        self.alldata.splice(0);
                    }

                }
            });
        },
        change_page: function (index) {
            this.current_page = index;
            this.get_product();
        },

        edit_product: function (id) {
            location.href = `product_edit.html?p_id=${id}`
        },
        delete_product: function (id, index, name) {
            let check = confirm('確定要刪除此商品 ' + name + ' ?');
            let self = this;
            if (check) {
                $.ajax({
                    type: "POST",
                    url: "../farm_project/php/product_manage/p_deletedata.php",
                    data: `p_id=${id}`,
                    success: function (response) {
                        if (index==0){
                            self.alldata.splice(index, index+1);
                        }else{
                            self.alldata.splice(index, index);
                        }
                        

                        alert(response + name);
                        self.count = self.count - 1;
                    }
                });
            }
        }




    },


});