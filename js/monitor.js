//控制上方面板顯示





let mointor = new Vue({
    el: '#monitor',
    data: {
        canlogout: false,
        message: "",
        session: {}

    },
    beforeCreate: function () {
    },

    created: function () {
    },

    beforeMount: function () {
        this.get_session();
    },

    mounted: function () {
    },


    methods: {
        logout: function () {
            $.ajax({
                url: "../farm_project/php/logout.php",
                type: "POST",
                processData: false,
                context: this,
                contentType: "application/json"
            }).done(function (response) {
                alert("成功登出");
                $.removeCookie("token");
                $.removeCookie("u_id");
                location.href = "index.html";
            }).fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                console.log(jqXHR.responseText);
                alert("發生錯誤");
            });


        },


        get_session: function () {
            $.ajax({
                url: "../farm_project/php/get_session.php",
                type: "POST",
                processData: false,
                context: this,
                contentType: "application/json"
            }).done(function (response) {
                let temp = JSON.parse(response);
                console.log(temp);
                //session驗證成功
                if (temp.status) {
                    this.session = temp;
                    this.canlogout = true;
                    this.message = $.cookie("token");
                    //驗證失敗
                } else {
                    //刪除殘留cookie
                    if ($.cookie('token') != undefined) {
                        alert(temp.message);
                        $.removeCookie("token");
                        $.removeCookie("u_id");
                    }
                    //如果在管理頁面則跳回首頁
                    let jump = true;
                    //頁面白名單
                    let str = [
                        "index",
                        "item"
                    ];
                    for (let index = 0; index < str.length; index++) {
                        const element = str[index];
                        if (location.pathname.includes(element)) {
                            jump = false;
                            break;
                        }
                    }
                    if (jump) {
                        //alert("跳回首頁");
                        self.location.href = 'index.html';
                    }
                }

            }).fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                console.log(jqXHR.responseText);
            });
        }


    }

});



