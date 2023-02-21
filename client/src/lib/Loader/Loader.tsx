import React from "react"

import s from "./Loader.module.scss"

const Loader = (): JSX.Element|null => {

   return (
      <div className={s.wrapper}>
         <svg height="120" viewBox="0 0 38 38" width="120"
                  xmlns="http://www.w3.org/2000/svg">
            <defs>
               <linearGradient id="a" x1="8.042%" x2="65.682%"
                                   y1="0%" y2="23.865%">
                  <stop offset="0%" stopColor="#f97035" stopOpacity="0"/>
                  <stop offset="63.146%" stopColor="#f97035" stopOpacity=".631"/>
                  <stop offset="100%" stopColor="#f97035"/>
               </linearGradient>
            </defs>
            <g fill="none" fillRule="evenodd">
               <g transform="translate(1 1)">
                  <path d="M36 18c0-9.94-8.06-18-18-18" id="Oval-2" stroke="url(#a)"
                            strokeWidth="2">
                     <animateTransform attributeName="transform"
                                           dur="0.9s"
                                           from="0 18 18"
                                           repeatCount="indefinite"
                                           to="360 18 18"
                                           type="rotate"/>
                  </path>
                  <circle cx="36" cy="18" fill="#f97035"
                              r="1">
                     <animateTransform attributeName="transform"
                                           dur="0.9s"
                                           from="0 18 18"
                                           repeatCount="indefinite"
                                           to="360 18 18"
                                           type="rotate"/>
                  </circle>
               </g>
            </g>
         </svg>
      </div>
   )

}

export default Loader