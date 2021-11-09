// Если добавить событие загрузки документа, все-равно не находит этот селектор
// let resultSection23 = document.querySelector(".roi-calculator-form__range-box--avg>.irs>.irs>.irs-min");
// resultSection23.textContent = "******";

// Default data values
let currentSessionsValue = 5000,
    currentSKUValue = 500,
    currentAverageOrderValue = 70

let sessionsMarks = []
const stepForSessionMarks = 1000
const maxValueForSessionMarks = 25000000
const minValueForSessionMarks = 5000
for (let i = minValueForSessionMarks; i <= maxValueForSessionMarks; i += stepForSessionMarks) {
    sessionsMarks.push(i)
}


const sessionValue = document.getElementById("roi-calc-session-value")
const fromValueForSessionsMarks = 0

$(".roi-calculator-form__range--sessions").ionRangeSlider({
    skin: "round",
    values: sessionsMarks,
    grid: false,
    from: fromValueForSessionsMarks,
    hide_min_max: true,
    onChange: (e) => {
        currentSessionsValue = e.from_value
        sessionValue.textContent = addThousandsSeparator(e.from_value)
    }
})

// ---------------------------------------------------

let SKUMarks = []
const stepForSKUMarks = 100
const maxValueForSKUMarks = 300000
const minValueForSKUMarks = 200
for (let i = minValueForSKUMarks; i <= maxValueForSKUMarks; i += stepForSKUMarks) {
    SKUMarks.push(i)
}

const SKUValue = document.getElementById("roi-calc-SKU-value")
const fromValueForSKUMarks = 0

$(".roi-calculator-form__range--SKU").ionRangeSlider({
    skin: "round",
    values: SKUMarks,
    grid: false,
    from: fromValueForSKUMarks,
    hide_min_max: true,
    prettify_separator: ',',
    onChange: (e) => {
        currentSKUValue = e.from_value
        SKUValue.textContent = addThousandsSeparator(e.from_value)
    }
})

// ---------------------------------------------------

let averageOrderMarks = []
const stepAverageOrderMarks = 10
const maxValueAverageOrderMarks = 500
const minValueAverageOrderMarks = 50
for (let i = minValueAverageOrderMarks; i <= maxValueAverageOrderMarks; i += stepAverageOrderMarks) {
    averageOrderMarks.push(i)
}

const averageOrderValue = document.getElementById("average-order-value")
const fromValueForAverageOrderMarks = 0

$(".roi-calculator-form__range--average-order").ionRangeSlider({
    skin: "round",
    values: averageOrderMarks,
    grid: false,
    from: fromValueForAverageOrderMarks,
    hide_min_max: true,
    prefix: "$",
    onChange: (e) => {
        currentAverageOrderValue = e.from_value
        averageOrderValue.textContent = "$" + e.from_value
    }
})


// ---------------------------------------------------
// Calculating Result
const calcResult = document.getElementById("calc-result")
const resultSection = document.querySelector(".roi-calculator-result")
const loader = document.getElementById("calc-loader")

// Boxes for result values
const aovResultBox = document.getElementById("AOV-result")
const cvrResultBox = document.getElementById("CVR-result")
const arpuResultBox = document.getElementById("ARPU-result")
const totalUpliftBox = document.getElementById("total-uplift")

calcResult.addEventListener(('click'), (e) => {
    e.preventDefault()
    resultSection.classList.remove("roi-calculator-result--active")
    loader.classList.add("roi-calculator-result__loader--active")

    // Timeout for loader
    setTimeout(() => {
        loader.classList.remove("roi-calculator-result__loader--active")
        resultSection.classList.add("roi-calculator-result--active")
    }, 1500)

    // someСalculations -- какой-то общий коефициент или что-то вроде этого (спросить)
    let someСalculations = 1 + (0.003 * (currentSKUValue - 200) / 3000)
    aovResultBox.textContent = Math.round((0.2 * 0.7 * someСalculations) * 100) + "%"
    cvrResultBox.textContent = Math.round((0.2 * 0.3 * someСalculations) * 100) + "%"
    arpuResultBox.textContent = Math.round((0.2 * someСalculations) * 100) + "%"
    totalUpliftBox.textContent = "$" + addThousandsSeparator(Math.round(currentSessionsValue * 0.025 * currentAverageOrderValue * 0.2 * someСalculations));

    // different styles/classes, for different result lengths
    if (totalUpliftBox.textContent.length > 7) {
        totalUpliftBox.classList.add("roi-calculator-result__total-uplift--large-value")
    } else if (totalUpliftBox.textContent.length <= 7) {
        totalUpliftBox.classList.remove("roi-calculator-result__total-uplift--large-value")
    }
})

function addThousandsSeparator(number) {
    const separator = ','
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, separator)
}