import React from "react"

import axios from "axios"

function App(): JSX.Element {

   React.useEffect(() => {
      axios.get("https://localhost:8000/api/calculator")
         .then(res => {
            console.warn(res)
         })
         .catch(err => {
            console.warn(err)
         })
   }, [])

   return (
      <div className="app">
         <p>Works!</p>
      </div>
   )
}

export default App
