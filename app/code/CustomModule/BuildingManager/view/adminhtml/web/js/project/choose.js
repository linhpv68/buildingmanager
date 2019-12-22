require([
        "jquery",
        'mage/url',
        "jquery/ui",
        "!domReady"
    ], function ($, urlBuilder) {
        var project = 'select[name="projectID"]';
        $(document).on('change', project, function () {
            if ($(project).val() != "") {
                console.log($(project).val());
                let url = urlBuilder.build('admin/buildingmanager/ajax/getroom');
                console.log(url);
                $.ajax({
                    url: window.location.origin + '/admin/buildingmanager/ajax/getroom',
                    type: 'POST',
                    data: {
                        projectID: $(project).val()
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.success) {
                            setOptionRoom(response.data);
                        }
                    },
                    error: function (error) {
                        console.log(error);
                        alert('error: ' + eval(error));
                    },
                    dataType: "json",
                });
            }
        });

        function setOptionRoom(data) {
            let html = "";
            html += '<option value="">  </option>';
            $(data).each(function (key, value) {
                html += '<option data-title="' + value.name + '" value="' + value.id + '">' + value.name + '</option>';
            });
            $('select[name="roomID"]').html(html)
        }

    }
);
