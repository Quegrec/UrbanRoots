const axios = require('axios');

const fetchSiteInfo = async () => {
    try {
        const res = await axios.get('http://localhost:5000/api/site-info', {
            headers: {
                'Content-Type': 'application/json',
            },
        });
        console.log('Fetched data:', res.data);
    } catch (error) {
        if (error.response) {
            console.error('Error response data:', error.response.data);
            console.error('Error response status:', error.response.status);
            console.error('Error response headers:', error.response.headers);
        } else if (error.request) {
            console.error('Error request:', error.request);
        } else {
            console.error('Error message:', error.message);
        }
        console.error('Error config:', error.config);
    }
};

fetchSiteInfo();
