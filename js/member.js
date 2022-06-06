
let member = new Vue({
    el: '#member',
    data: {
        name:"",
        img_data: "",
        img_display: "img/upload_icon.svg",
        region: "",
        phone: "",
        description: "",
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
    beforeCreate: function () {
    },
    mounted: function () {

        if ($.cookie('token') != undefined) {

            let self = this;
            $.ajax({
                url: "../farm_project/php/loadmember.php",
                type: "GET",
                data: `u_id=${$.cookie("u_id")}`,
                processData: false,
                context: this,
                contentType: "application/json"
            }).done(function (msg) {
                let jsonmsg = JSON.parse(msg);
                console.log(jsonmsg);
                if (jsonmsg.pass) {
                    self.region = jsonmsg.region;
                    self.description = jsonmsg.description;
                    self.phone = jsonmsg.phone;
                    self.img_display = "img_data/member/" + jsonmsg.img;
                    self.name = jsonmsg.name;
                }
            }).fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                console.log(jqXHR.responseText);
            });
        }



    },
    methods: {


        fileSelected: function (e) {
            let file = e.target.files.item(0);
            const reader = new FileReader();
            if (file.type.includes("image")) {
                if (file.size / 1024 / 1024 < 3) {
                    this.img_data = file;
                    reader.readAsDataURL(file);
                    reader.onload = () => {
                        this.img_display = reader.result;
                    };
                } else {
                    alert("檔案過大");
                }
            }
        },

        savedata: function () {
            let param = {
                "name":this.name,
                "location": this.region,
                "phone": this.phone,
                "description": this.description,
                "u_id": $.cookie("u_id")
            };
            let formdata = new FormData();
            formdata.append("member_data", JSON.stringify(param));
            if (typeof this.img_data !== 'undefined') {
                formdata.append("img", this.img_data);
            }

            $.ajax({
                url: "../farm_project/php/savemember.php",
                type: "POST",
                data: formdata,
                contentType: false,
                processData: false,
            }).done(function (msg) {
                alert(msg);
                window.location.reload();

            }).fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                console.log(jqXHR.responseText);
            });

        }

    }

});

