import React from "react"

import Calculator from "./components/Calculator/Calculator"
import Wrapper from "./lib/Wrapper/Wrapper"

function App(): JSX.Element {

   return (
      <Wrapper>
         <Calculator/>
      </Wrapper>
   )
}

export default App
