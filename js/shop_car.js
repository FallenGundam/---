let shopcar = new Vue({
    el: '#shop_car',
    data: {
        p_list: [
        ]

    },
    beforeCreate: function () { },
    created: function () { },
    beforeMount: function () {
        this.shop_car_load();
    },
    mounted: function () { },
    computed: {},
    watch: {},
    methods: {
        shop_car_ADD: function () {
            for (let index = 0; index < this.p_list.length; index++) {
                const element = this.p_list[index];
                if (p_id == element.p_id) {
                    alert('該商品已存在願望清單中');
                    return;
                }
            }
            let jsondata = {
                'p_id': p_id,
                'u_id': $.cookie("u_id"),
                'amount': '1',
            }
            let self = this;
            $.ajax({
                type: "POST",
                url: "../farm_project/php/shop_car_ADD.php",
                data: JSON.stringify(jsondata),
                success: function (response) {
                    alert('成功添加商品')
                    self.shop_car_load();
                    //self.location.reload();
                }
            });


        },

        shop_car_load: function () {
            this.p_list=[];
            let self = this;
            $.ajax({
                type: "GET",
                url: "../farm_project/php/shop_car_GET.php",
                data: `u_id=${$.cookie("u_id")}`,
                dataType: "json",
                success: function (response) {
                    if (response.length > 0) {
                        response.forEach(element => {
                            let temp = JSON.parse(element);
                            temp.img_src = "img_data/" + temp.img_src;
                            self.p_list.push(temp);
                        });
                    }

                    //console.log(self.p_list);
                }
            });
        },

        shop_car_link: function (index) {  
            window.open(`item.html?p_id=${this.p_list[index].p_id}`);
        },


        shop_car_delete: function (index) {
            let id = this.p_list[index].p_id;
            let temp = this.p_list[index].name;
            let bool = confirm(`確定要刪除商品 ${temp} ?`)
            if (bool) {
                let self = this;
                $.ajax({
                    type: "POST",
                    url: "../farm_project/php/shop_car_DELETE.php",
                    data: `p_id=${id}&u_id=${$.cookie("u_id")}`,
                    success: function (response) {
                        alert('成功刪除商品')
                        if (index==0){
                            self.p_list.splice(index, index+1);
                        }else{
                            self.p_list.splice(index, index);
                        }
                        
                        //self.location.reload();
                    }
                });
            }



        },




    }
});