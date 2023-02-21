import React from "react"

import s from "./CalculatorScreen.module.scss"

type CalculatorScreenType = {
    value: string
}

const CalculatorScreen: React.FC<CalculatorScreenType> = ({ value }): JSX.Element => {
   return (
      <input className={s.screen} name="screen" readOnly={true}
               type="text"
               value={value}/>
   )
}

export default CalculatorScreen