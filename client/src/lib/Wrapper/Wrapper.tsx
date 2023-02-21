import React from "react"

import s from "./Wrapper.module.scss"

type WrapperType = {
    children: React.ReactNode
}

const Wrapper: React.FC<WrapperType> = ({ children }): JSX.Element => {
   return (
      <div className={s.wrapper}>
         {children}
      </div>
   )
}

export default Wrapper