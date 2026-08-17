$(document).ready(function () {

    // Form validation
    $("#billForm").submit(function (event) {

        let name = $("#name").val().trim();
        let units = $("#units").val().trim();

        let valid = true;


        // Clear previous errors

        $("#nameError").text("");
        $("#unitsError").text("");

        $("#name").css("border-color", "#d1d5db");
        $("#units").css("border-color", "#d1d5db");


        // Name validation

        if (name === "") {

            $("#nameError").text("Please enter your name.");

            $("#name").css("border-color", "#dc2626");

            valid = false;

        }


        // Units validation

        if (units === "") {

            $("#unitsError").text("Please enter units consumed.");

            $("#units").css("border-color", "#dc2626");

            valid = false;

        }

        else if (units < 0) {

            $("#unitsError").text("Units cannot be negative.");

            $("#units").css("border-color", "#dc2626");

            valid = false;

        }


        // Prevent submission if invalid

        if (!valid) {

            event.preventDefault();

            return;

        }


        // Change button while calculating

        $("#calculateBtn").html(
            '<i class="fa-solid fa-spinner fa-spin"></i> Calculating...'
        );

    });


    // Remove name error while typing

    $("#name").on("input", function () {

        if ($(this).val().trim() !== "") {

            $("#nameError").text("");

            $(this).css("border-color", "#d1d5db");

        }

    });


    // Remove units error while typing

    $("#units").on("input", function () {

        if ($(this).val() >= 0 && $(this).val() !== "") {

            $("#unitsError").text("");

            $(this).css("border-color", "#d1d5db");

        }

    });


    // Reset button

    $("#resetBtn").click(function () {

        $("#name").val("");
        $("#units").val("");

        $("#nameError").text("");
        $("#unitsError").text("");

        $("#name").css("border-color", "#d1d5db");
        $("#units").css("border-color", "#d1d5db");

    });


});