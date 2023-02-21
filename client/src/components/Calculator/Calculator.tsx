import React from "react"

import s from "./Calculator.module.scss"
import CalculatorButtons from "./CalculatorButtons"
import CalculatorScreen from "./CalculatorScreen"
import Button from "../../lib/Button/Button"
import { handleCalculatorType } from "../../utils/handleCalculatorType"
import Calculations from "../Calculations/Calculations"

const calculatorButton = [7, 8, 9, "/", 4, 5, 6, "*", 1, 2, 3, "-", 0, "=", "+"]

const Calculator = (): JSX.Element => {

   const [expression, setExpression] = React.useState<(string | number)[]>([])
   const [result, setResult] = React.useState<string | number>("")

   const handleOperation = (value: string | number): void => {
      setExpression([
         ...expression,
         value
      ])
   }

   const handleEquals = (): void => {
      const result = expression
         .join("")
         .split(/(\D)/g)
         .map(value => (value.match(/\d/g) ? parseInt(value, 0) : value))
         .reduce((acc, value, index, array) => {
            switch (value) {
            case "+":
               return (acc = acc as number + (array[index + 1] as number))
            case "-":
               return (acc = acc as number - (array[index + 1] as number))
            case "*":
               return (acc = acc as number * (array[index + 1] as number))
            case "/":
               return (acc = acc as number / (array[index + 1] as number))
            default:
               return acc
            }
         })
      setResult(result)
   }

   return (
      <React.Fragment>

         <div className={s.wrapper}>

            <CalculatorScreen value={expression.join("")}/>

            <CalculatorButtons>

               {calculatorButton.map(btn => (
                  <Button key={btn} disabled={expression.length === 0} handleEquals={handleEquals}
                                handleOperation={handleOperation}
                                type={handleCalculatorType(btn)}
                                value={btn}/>
               ))}

            </CalculatorButtons>

         </div>

         <Calculations expression={expression} result={result} setExpression={setExpression}
                          setResult={setResult}/>

      </React.Fragment>
   )
}

export default Calculator