import flattenColorPalette from "tailwindcss/lib/util/flattenColorPalette";

/** @type {import('tailwindcss').Config} */
const config = {
  content: ["./index.html", "./src/**/*.{ts,tsx}"],
  darkMode: "class",
  theme: {
    extend: {
      animation: {
        aurora: "aurora 60s linear infinite",
        float: "float 8s ease-in-out infinite",
      },
      boxShadow: {
        glow: "0 24px 80px rgba(120, 82, 255, 0.22)",
      },
      colors: {
        brand: {
          50: "#f7f4ff",
          100: "#efe9ff",
          200: "#ddd1ff",
          300: "#c5b0ff",
          400: "#ab85ff",
          500: "#8a5cff",
          600: "#7340f4",
          700: "#5f30d4",
          800: "#4e2bab",
          900: "#41298a"
        }
      },
      keyframes: {
        aurora: {
          from: {
            backgroundPosition: "50% 50%, 50% 50%"
          },
          to: {
            backgroundPosition: "350% 50%, 350% 50%"
          }
        },
        float: {
          "0%, 100%": {
            transform: "translateY(0px)"
          },
          "50%": {
            transform: "translateY(-10px)"
          }
        }
      }
    }
  },
  plugins: [addVariablesForColors]
};

function addVariablesForColors({ addBase, theme }) {
  const allColors = flattenColorPalette(theme("colors"));
  const newVars = Object.fromEntries(
    Object.entries(allColors).map(([key, val]) => [`--${key}`, val])
  );

  addBase({
    ":root": newVars
  });
}

export default config;
