describe('Tween.js', function() {
	beforeEach(module('LCP'));

	var _$injector;

	beforeEach(inject(function($injector){
		_$injector = $injector;
	}));


	it('should be registered in the injector', function () {
		_$injector.get('Tween');
	});

	it('should be be equal to the global tween object', function () {
		var Tween = _$injector.get('Tween');
		expect(Tween()).to.be.an.instanceof(window.TWEEN.Tween);
	});

});