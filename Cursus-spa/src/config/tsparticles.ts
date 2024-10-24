import { type ILoadParams } from "@tsparticles/engine";

export default {
  id: "particles",
  options: {
    "key": "reactNightSky",
    "name": "React Night Sky",
    "particles": {
      "color": {
        "value": "#FFF"
      },
      "links": {
        "blink": true,
        "color": {
          "value": "#fff"
        },
        "consent": false,
        "distance": 150,
        "enable": true,
        "opacity": 0.02,
        "shadow": {
          "blur": 5,
          "color": {
            "value": "lime"
          },
          "enable": false
        },
        "width": 1
      },
      "move": {
        "attract": {
          "enable": false,
          "rotate": {
            "x": 3000,
            "y": 3000
          }
        },
        "enable": true,
        "outModes": "bounce",
        "speed": 0.05
      },
      "collisions": {
        "enable": true
      },
      "number": {
        "density": {
          "enable": true
        },
        "value": 1500
      },
      "opacity": {
        "animation": {
          "enable": true,
          "speed": 1,
          "sync": false
        },
        "value": {
          "min": 0.05,
          "max": 0.5
        }
      },
      "shape": {
        "type": "circle"
      },
      "size": {
        "value": 1
      }
    },
    "pauseOnBlur": true,
    "fullScreen": {
      "enable": false
    }
  }
} as ILoadParams;