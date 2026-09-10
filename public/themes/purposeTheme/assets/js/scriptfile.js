$(document).ready(function() {
    $("#ShipTable").DataTable({
        order: [
            [0, "desc"]
        ],
        dom: "Bfrtip",
        buttons: ["copy", "csv", "print", "excel", "pdf"],
    });
});

$(document).ready(function() {
    $("#OthersTable").DataTable({
        order: [],
    });
});

$(document).ready(function() {
    $("#WithdrawTbl").DataTable({
        order: [],
    });
});

$(document).ready(function() {
    $("#DeposTbl").DataTable({
        order: [],
    });
});

$("#usernameinput").on("keypress", function(e) {
    return e.which !== 32;
});

$(document).ready(function() {
    $(".UserTable").DataTable({
        order: [
            [0, "desc"]
        ],
    });
});

function googleTranslateElementInit() {
    new google.translate.TranslateElement({ pageLanguage: "en" },
        "google_translate_element"
    );
}