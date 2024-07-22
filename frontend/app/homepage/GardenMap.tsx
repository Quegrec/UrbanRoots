import React, { useState, useEffect } from 'react';
import { MapContainer, Marker, TileLayer, Popup } from 'react-leaflet';
import 'leaflet/dist/leaflet.css';
import Papa from 'papaparse';
import 'tailwindcss/tailwind.css'; // Ensure Tailwind CSS is installed

interface Garden {
  name: string;
  address: string;
  email: string;
  position: [number, number];
}

const GardenMap: React.FC = () => {
  const [gardens, setGardens] = useState<Garden[]>([]);

  useEffect(() => {
    // Fetch and parse the CSV file
    fetch('/jardins-partages.csv')
      .then(response => response.text())
      .then(csvText => {
        Papa.parse(csvText, {
          header: true,
          skipEmptyLines: true, // Skip empty lines to avoid errors
          complete: (result) => {
            console.log("CSV Parsing Result:", result.data); // Debug: log parsed data

            const gardensData: Garden[] = result.data
              .map((garden: any) => {
                const coordsStr = garden.geo_point_2d;
                if (coordsStr) {
                  const coords = coordsStr.split(',').map(Number);
                  if (coords.length === 2 && !isNaN(coords[0]) && !isNaN(coords[1])) {
                    return {
                      name: garden.nom_ev,
                      address: garden.adresse,
                      email: garden.mail_1,
                      position: [coords[1], coords[0]] as [number, number], // Ensure correct order: [latitude, longitude]
                    };
                  }
                }
                return null; // Return null for invalid entries
              })
              .filter((garden): garden is Garden => garden !== null); // Filter out invalid entries

            console.log("Parsed Gardens Data:", gardensData); // Debug: log gardens data
            setGardens(gardensData);
          },
          error: (error) => {
            console.error("Error parsing CSV:", error); // Debug: log any parsing errors
          },
        });
      })
      .catch(error => {
        console.error("Error fetching CSV file:", error); // Debug: log any fetch errors
      });
  }, []);

  return (
    <div className="flex justify-center items-center h-screen bg-gray-100">
      <div className="w-full h-4/5">
        <MapContainer center={[46.603354, 1.888334]} zoom={6} style={{ height: '100%', width: '100%' }}>
          <TileLayer
            url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
          />
          {gardens.map((garden, idx) => (
            <Marker key={idx} position={garden.position}>
              <Popup>
                <h3>{garden.name}</h3>
                <p>{garden.address}</p>
                <p>{garden.email}</p>
              </Popup>
            </Marker>
          ))}
        </MapContainer>
      </div>
    </div>
  );
};

export default GardenMap;
