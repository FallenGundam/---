
let pagetotal = 16;
let search = new Vue({
    el: '#index',
    data: {

        keywords: "",
        type: "",
        city: "",

        //  DESC降冪 ASC升冪
        date_sort: "",
        price_sort: "",

        allresult: [],
        current_page: 1,
        ALL_page: 1,
        result_count:0,

        Allcity: [],

        
    },
    beforeCreate: function () {
    },
    created: function () {
    },
    beforeMount: function () {
        let thisobj = this;
        $.getJSON("./json_data/CityData.json",
            function (data, textStatus, jqXHR) {
                thisobj.Allcity = data;
            });
    },

    mounted: function () {
        this.search_product();

    },
    computed: {
    },
    watch: {
    },


    methods: {
        search_product: function () {


            let requestText = `keywords=${this.keywords.trim()}&pagetotal=${pagetotal}&page=${this.current_page}`

            let temparr = ['city', 'type', 'date_sort', 'price_sort'];
            temparr.forEach(element => {
                if (this[element] !== "") {
                    requestText = requestText + `&${element}=${this[element]}`;
                }
            });
            console.log(requestText);
            let self = this;
            $.ajax({
                type: "GET",
                url: "../farm_project/php/index_search.php",
                data: requestText,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response.found) {
                        self.ALL_page = Math.ceil(response.count / pagetotal);
                        for (let index = 0; index < response.list.length; index++) {
                            response.list[index] = JSON.parse(response.list[index]);
                            if (response.list[index].img_src.includes('notfound')) {
                                response.list[index].img_src = "img/upload_icon.svg";
                            } else {
                                response.list[index].img_src = `img_data/${response.list[index].img_src}`;
                            }
                        }
                        self.result_count = response.count;
                        self.allresult = response.list;    
                    }
                    else{
                        self.result_count=0;
                        self.allresult.splice(0);
                        ALL_page=1;
                    }
                }           
             });

        },


        change_page: function (index) {
            this.current_page = index;
            this.search_product();
        },

    }
});

