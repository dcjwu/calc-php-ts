
const operations = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "+", "-", "/", "*"]
export const handleCalculatorType = (value: string|number): "operation" | "equal" => {

   if (value === "=") return "equal"

   if (operations.includes(value)) return "operation"

   return "equal"
}