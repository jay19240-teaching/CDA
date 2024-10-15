<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router';
import { ref, onMounted, computed } from 'vue';
import NotifBar from '@/components/NotifBar.vue';
import Particles from "@tsparticles/vue3";
import { type Engine, type ILoadParams, tsParticles } from "@tsparticles/engine";
import { loadAll } from "@tsparticles/all";
import configs from "@tsparticles/configs";

const config: ILoadParams = {
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
};

onMounted(async () => {
  await loadAll(tsParticles);
  await tsParticles.load(config);
});
</script>

<template>
  <NotifBar />
  <header class="header">
    <div id="particles" class="particles"></div>
    <img src="/logo.png" id="logo" class="header-logo" />
  </header>
  <RouterView />

  <div class="nav">
    <input type="checkbox" id="btn" hidden>
    <label for="btn" class="nav-btn">
      <span class="material-symbols-outlined">person</span>
      <span class="material-symbols-outlined">close</span>
    </label>
    <nav id="sidebar">
      <div class="title">Side Menu</div>
      <ul class="list-items">
        <li><a href="#"><i class="fas fa-home"></i>Home</a></li>
        <li><a href="#"><i class="fas fa-sliders-h"></i>Clients</a></li>
        <li><a href="#"><i class="fas fa-address-book"></i>Services</a></li>
        <li><a href="#"><i class="fas fa-cog"></i>Settings</a></li>
        <li><a href="#"><i class="fas fa-stream"></i>Features</a></li>
        <li><a href="#"><i class="fas fa-user"></i>About us</a></li>
        <li><a href="#"><i class="fas fa-globe-asia"></i>Languages</a></li>
        <li><a href="#"><i class="fas fa-envelope"></i>Contact us</a></li>
      </ul>
    </nav>
  </div>
</template>