import React from "react"

import s from "./CalculationsItem.module.scss"

type CalculationsItemType = {
    isHeader?: boolean,
    isGrey?: boolean
    calculatorId?: number
    id?: number
    expression?: string
    result?: string
}

const CalculationsItem: React.FC<CalculationsItemType> = ({
   isGrey,
   isHeader,
   calculatorId,
   id,
   expression,
   result
}): JSX.Element => {

   const bgc = { backgroundColor: isGrey ? "lightgray" : "" }

   if (isHeader) {
      return (
         <div className={s.wrapper} style={bgc}>
            <p>Calculator ID</p>
            <p>ID</p>
            <p>Expression</p>
            <p>Result</p>
         </div>
      )
   }

   return (
      <div className={s.wrapper} style={bgc}>
         <p>{calculatorId}</p>
         <p>{id}</p>
         <p>{expression}</p>
         <p>{result}</p>
      </div>
   )
}

export default CalculationsItem