const marks = ['5000', '100000', '25000000'];

$(".roi-calculator-form__range").ionRangeSlider({
    skin: "round",
    values: marks,
    grid: false,
    from: 5,
    hide_min_max: false,
    step: 1000
});