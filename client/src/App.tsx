import React from "react"

import axios from "axios"

function App(): JSX.Element {

   React.useEffect(() => {
      axios.get("http://localhost:8888/api/calculations")
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

         <p>Works from docker as well, as I can see...</p>
      </div>
   )
}

export default App
