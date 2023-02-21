import React from "react"

import s from "./CalculatorButtons.module.scss"


type CalculatorButtonsType = {
   children: React.ReactNode
}

const CalculatorButtons: React.FC<CalculatorButtonsType> = ({ children }): JSX.Element => {
   return (
      <div className={s.wrapper}>
         {children}
      </div>
   )
}

export default CalculatorButtons