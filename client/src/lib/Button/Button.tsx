import React from "react"

import s from "./Button.module.scss"

type ButtonType = {
    value: string|number
    type: "operation" | "equal"
    handleOperation: (value: string|number) => void
    handleEquals: () => void
    disabled: boolean
}
const Button: React.FC<ButtonType> = ({ value, type, handleOperation, handleEquals, disabled }): JSX.Element|null => {

   if (type === "operation") {
      return (
         <div>
            <button className={s.btn} disabled={typeof value === "string" && disabled} onClick={(): void => handleOperation(value)}>{value}</button>
         </div>
      )
   }

   if (type === "equal") {
      return (
         <div>
            <button className={s.btn} onClick={(): void => handleEquals()}>{value}</button>
         </div>
      )
   }

   return null
}

export default Button