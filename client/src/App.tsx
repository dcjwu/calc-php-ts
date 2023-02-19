import React from "react"

import axios from "axios"

interface CalculationsInterface {
    calculatorId: number
    id: number
    expression: string
    result: number
}

function App(): JSX.Element {

   const [calculations, setCalculations] = React.useState<CalculationsInterface[]>([])

   React.useEffect(() => {
      axios.post("http://localhost:8888/api/calculator", {},)
         .then(res => {
            setCalculations(res.data.items)
         })
         .catch(err => {
            console.warn(err)
         })
   }, [])

   return (
      <div className="app">
         <p>Works!</p>

         <p>Works from docker as well, as I can see...</p>

         {
            calculations.map(calc => (
               <div key={calc.id}>
                  <p>{calc.calculatorId}</p>
                  <p>{calc.id}</p>
                  <p>{calc.expression}</p>
                  <p>{calc.result}</p>
               </div>
            ))
         }
      </div>
   )
}

export default App
