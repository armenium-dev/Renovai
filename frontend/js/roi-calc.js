let currentSessionsValue = 0,
    currentSKUValue = 0,
    currentAverageOrderValue = 0

let sessionsMarks = []
const stepForSessionMarks = 1000
const maxValueForSessionMarks = 25000000
for (let i = 0; i <= maxValueForSessionMarks; i += stepForSessionMarks) {
    sessionsMarks.push(i)
}

const sessionValue = document.getElementById("roi-calc-session-value")
const fromValueForSessionsMarks = 0

$(".roi-calculator-form__range--sessions").ionRangeSlider({
    skin: "round",
    values: sessionsMarks,
    grid: false,
    from: fromValueForSessionsMarks,
    hide_min_max: false,
    onChange: (e) => {
        currentSessionsValue = e.from_value
        sessionValue.textContent = e.from_value
    }
})

// ---------------------------------------------------

let SKUMarks = []
const stepForSKUMarks = 100
const maxValueForSKUMarks = 300000
for (let i = 0; i <= maxValueForSKUMarks; i += stepForSKUMarks) {
    SKUMarks.push(i)
}

const SKUValue = document.getElementById("roi-calc-SKU-value")
const fromValueForSKUMarks = 0

$(".roi-calculator-form__range--SKU").ionRangeSlider({
    skin: "round",
    values: SKUMarks,
    grid: false,
    from: fromValueForSKUMarks,
    hide_min_max: false,
    onChange: (e) => {
        currentSKUValue = e.from_value
        SKUValue.textContent = e.from_value
    }
})

// ---------------------------------------------------

let averageOrderMarks = []
const stepAverageOrderMarks = 10
const maxValueAverageOrderMarks = 500
for (let i = 0; i <= maxValueAverageOrderMarks; i += stepAverageOrderMarks) {
    averageOrderMarks.push(i)
}

const averageOrderValue = document.getElementById("average-order-value")
const fromValueForAverageOrderMarks = 0

$(".roi-calculator-form__range--average-order").ionRangeSlider({
    skin: "round",
    values: averageOrderMarks,
    grid: false,
    from: fromValueForAverageOrderMarks,
    hide_min_max: false,
    onChange: (e) => {
        currentAverageOrderValue = e.from_value
        averageOrderValue.textContent = e.from_value
    }
})

// ---------------------------------------------------

const calcResult = document.getElementById("calc-result")
const resultSection = document.querySelector(".roi-calculator-result")

const aovResultBox = document.getElementById("AOV-result")
const cvrResultBox = document.getElementById("CVR-result")
const arouResultBox = document.getElementById("ARPU-result")
const totalUpliftBox = document.getElementById("total-uplift")

calcResult.addEventListener(('click'), (e) => {
    e.preventDefault()

    alert(currentSessionsValue + " " + currentSKUValue + " " + currentAverageOrderValue)
    resultSection.classList.add("roi-calculator-result--active")
    aovResultBox.textContent = "111"
    cvrResultBox.textContent = "222"
    arouResultBox.textContent = "333"
    totalUpliftBox.textContent = "444"
})