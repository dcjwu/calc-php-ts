import React from "react"

import axios from "axios"

import s from "./Calculations.module.scss"
import CalculationsItem from "./CalculationsItem"
import Loader from "../../lib/Loader/Loader"

interface CalculationsInterface {
    calculatorId: number
    id: number
    expression: string
    result: string
}

type CalculationsType = {
    result: string | number
    expression: (string | number)[]
    setExpression: React.Dispatch<React.SetStateAction<(string | number)[]>>
    setResult: React.Dispatch<React.SetStateAction<string | number>>
}

const Calculations: React.FC<CalculationsType> = ({ result, expression, setResult, setExpression }): JSX.Element => {

   const [calculations, setCalculations] = React.useState<CalculationsInterface[]>([])
   const [loading, setLoading] = React.useState<boolean>(false)

   React.useEffect(() => {
      setLoading(true)
      if (result) {
         axios.post("http://localhost:8888/api/calculations", {
            expression: expression.join("").split(/(\D)/g).join(" "),
            result: (result as number) % 1 === 0 ? result.toString() : (result as number).toFixed(2)
         }, { withCredentials: true })
            .then(() => {
               axios.get("http://localhost:8888/api/calculations", { withCredentials: true })
                  .then(res => {
                     setCalculations(res.data)
                  })
                  .catch(err => {
                     console.warn(err)
                  })
                  .finally(() => {
                     setExpression([])
                     setResult("")
                     setLoading(false)
                  })
            })
            .catch(err => {
               console.warn(err)
            })

      } else {
         axios.get("http://localhost:8888/api/calculations", { withCredentials: true })
            .then(res => {
               setCalculations(res.data)
            })
            .catch(err => {
               console.warn(err)
            })
            .finally(() => {
               setLoading(false)
            })
      }
   }, [result])

   return (
      <div className={s.wrapper}>
         <h2 className={s.title}>History</h2>

         <CalculationsItem isHeader={true}/>

         {loading
            ? <Loader/>
            : calculations.map((item, index) => (
               <React.Fragment key={item.id}>
                  <CalculationsItem calculatorId={item.calculatorId} expression={item.expression} id={item.id}
                                        isGrey={index % 2 === 0}
                                        result={item.result}/>
               </React.Fragment>
            ))}

      </div>
   )
}

export default Calculations