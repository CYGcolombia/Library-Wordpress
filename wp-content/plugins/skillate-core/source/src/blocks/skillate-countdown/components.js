const { __ } = wp.i18n;
const { Component } = wp.element;

class Timer extends Component {
	constructor(props) {
		super(props);
		this.state = { timeLeft: this.remainingTime() };
	}
	remainingTime = () => {
		return this.props.deadline - Math.floor(Date.now() / 1000);
	};
	componentDidMount() {
		if (this.props.deadline - Math.floor(Date.now() / 1000) > 0) {
			this.tick = setInterval(this.ticker, 1000);
		}
	}
	ticker = () => {
		this.setState({
			timeLeft: this.remainingTime()
		});
	};
	componentWillReceiveProps( newProps ) {
		if (newProps.deadline !== this.props.deadline) {
			clearInterval(this.tick);
			let timeLeft = newProps.deadline - Math.floor(Date.now() / 1000);
			this.setState({
				timeLeft: timeLeft
			});
			if (timeLeft > 0) {
				this.tick = setInterval(this.ticker, 1000);
			}
		}
	}
	componentDidUpdate() {
		if (this.state.timeLeft <= -1) {
			clearInterval(this.tick);
		}
	}
	componentWillUnmount() {
		clearInterval(this.tick);
	}
	render() {
		const { timeLeft } 	= this.state;
		const seconds 		= timeLeft % 60;
		const minutes 		= ((timeLeft - seconds) % 3600) / 60;
		const hours 		= ((timeLeft - minutes * 60 - seconds) % 86400) / 3600;
		const days 			= parseInt((timeLeft - hours / 3600 / minutes * 60 - seconds) / 86400 );
	
		const defaultFormat = (
			<div className="skillate-home-countdown-wrapper">
				<div className="skillate-home-countdown-item">
					<div className="number"><h4>{` ${days} `}</h4></div>
					<div className="text"><h5>{` ${__('days', 'Skillate-core')} `}</h5></div>
				</div>
				<div className="skillate-home-countdown-item">
					<div className="number"><h4>{` ${hours} `}</h4></div>
					<div className="text"><h5>{` ${__('Hours', 'Skillate-core')} `}</h5></div>
				</div>
				<div className="skillate-home-countdown-item">
					<div className="number"><h4>{` ${minutes} `}</h4></div>
					<div className="text"><h5>{` ${__('Minutes', 'Skillate-core')} `}</h5></div>
				</div>
				<div className="skillate-home-countdown-item">
					<div className="number"><h4>{` ${seconds} `}</h4></div>
					<div className="text"><h5>{` ${__('Seconds', 'Skillate-core')} `}</h5></div>
				</div>
			</div>		
		);
		
		return defaultFormat;
	}
}

export default Timer;
